<?php

namespace App\Livewire\PaymentRequests;

use App\Models\Budget;
use App\Models\Department;
use App\Models\Project;
use App\Models\CostCenter;
use App\Models\PaymentRequest;
use App\Models\LineItem;
use App\Services\PaymentRequestService;
use Livewire\Component;
use Livewire\WithFileUploads;
use NumberFormatter;

class Create extends Component
{
    use WithFileUploads;

    public $title = '';
    public $description = '';
    public $expense_type = 'OPEX';
    public $currency = 'GHS';
    public $purpose = '';
    public $prepared_by = '';
    public $request_date;
    public $vendor_name = '';
    public $vendor_email = '';
    public $vendor_phone = '';
    public $comments = '';
    public $department_name = '';
    public $project_name = '';
    public $budget_id = '';
    
    public $lineItems = [];
    public $attachments = [];
    public $invoiceFiles = [];

    public function mount()
    {
        $this->prepared_by = auth()->user()->name;
        $this->request_date = now()->format('Y-m-d');
        $this->addLineItem();
    }

    public function removeAttachment($index)
    {
        unset($this->invoiceFiles[$index]);
        $this->invoiceFiles = array_values($this->invoiceFiles);
    }

    public function addLineItem()
    {
        $this->lineItems[] = [
            'description' => '',
            'quantity' => 1,
            'unit_price' => 0,
        ];
    }

    public function removeLineItem($index)
    {
        unset($this->lineItems[$index]);
        $this->lineItems = array_values($this->lineItems);
    }

    public function calculateTotal()
    {
        return collect($this->lineItems)->sum(function ($item) {
            $quantity = is_numeric($item['quantity'] ?? 0) ? (float) $item['quantity'] : 0;
            $unitPrice = is_numeric($item['unit_price'] ?? 0) ? (float) $item['unit_price'] : 0;
            return $quantity * $unitPrice;
        });
    }

    public function saveDraft()
    {
        $this->save('draft');
    }

    public function submit()
    {
        $this->save('submit');
    }

    protected function save($action)
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'expense_type' => 'required|in:OPEX,CAPEX',
            'currency' => 'required|in:GHS,USD,EUR',
            'purpose' => 'required|string',
            'prepared_by' => 'required|string',
            'request_date' => 'required|date',
            'budget_id' => 'required|exists:budgets,id',
            'lineItems' => 'required|array|min:1',
            'lineItems.*.description' => 'required|string',
            'lineItems.*.quantity' => 'required|numeric|min:1',
            'lineItems.*.unit_price' => 'required|numeric|min:0',
            'invoiceFiles.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $amount = $this->calculateTotal();
        
        // Handle department - find or create
        $departmentId = null;
        if (!empty($this->department_name)) {
            $department = Department::firstOrCreate(
                ['name' => trim($this->department_name)],
                ['code' => strtoupper(substr(trim($this->department_name), 0, 3))]
            );
            $departmentId = $department->id;
        }

        // Handle project - find or create
        $projectId = null;
        if (!empty($this->project_name)) {
            $project = Project::firstOrCreate(
                ['name' => trim($this->project_name)],
                [
                    'code' => strtoupper(substr(trim($this->project_name), 0, 3)) . '-' . date('Y'),
                    'status' => 'active',
                    'start_date' => now(),
                    'end_date' => now()->addYear(),
                ]
            );
            $projectId = $project->id;
        }
        
        $paymentRequest = PaymentRequest::create([
            'title' => $this->title,
            'description' => $this->description,
            'amount' => $amount,
            'currency' => $this->currency,
            'amount_in_words' => $this->convertAmountToWords($amount, $this->currency),
            'status' => 'draft',
            'expense_type' => $this->expense_type,
            'purpose' => $this->purpose,
            'prepared_by' => $this->prepared_by,
            'request_date' => $this->request_date,
            'vendor_name' => $this->vendor_name,
            'vendor_details' => [
                'email' => $this->vendor_email,
                'phone' => $this->vendor_phone,
                'comments' => $this->comments,
            ],
            'department_id' => $departmentId,
            'project_id' => $projectId,
            'cost_center_id' => null,
            'budget_id' => $this->budget_id,
            'requester_id' => auth()->id(),
        ]);

        foreach ($this->lineItems as $index => $item) {
            LineItem::create([
                'payment_request_id' => $paymentRequest->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['quantity'] * $item['unit_price'],
                'line_order' => $index,
            ]);
        }

        // Handle file uploads
        if (!empty($this->invoiceFiles)) {
            foreach ($this->invoiceFiles as $file) {
                $filename = $file->getClientOriginalName();
                $path = $file->store('payment-requests/' . $paymentRequest->id, 'public');
                
                \App\Models\Attachment::create([
                    'payment_request_id' => $paymentRequest->id,
                    'filename' => $filename,
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'uploaded_by' => auth()->id(),
                ]);
            }
        }

        if ($action === 'submit') {
            $service = app(PaymentRequestService::class);
            $service->submitRequest($paymentRequest, auth()->user());
            session()->flash('message', 'Payment request submitted successfully!');
        } else {
            session()->flash('message', 'Draft saved successfully!');
        }

        return redirect()->route('payment-requests.show', $paymentRequest);
    }

    protected function convertAmountToWords($amount, $currency = 'GHS')
    {
        $formatter = new NumberFormatter('en', NumberFormatter::SPELLOUT);
        $currencyName = match($currency) {
            'GHS' => 'Ghana Cedis',
            'USD' => 'US Dollars',
            'EUR' => 'Euros',
            default => 'Ghana Cedis'
        };
        return ucfirst($formatter->format($amount)) . ' ' . $currencyName;
    }

    public function render()
    {
        $budgets = Budget::where('status', 'approved')
            ->where('period_end', '>=', now())
            ->get();
        $departments = Department::all();
        $projects = Project::where('status', 'active')->get();

        return view('livewire.payment-requests.create', [
            'budgets' => $budgets,
            'departments' => $departments,
            'projects' => $projects,
            'totalAmount' => $this->calculateTotal(),
        ])->layout('components.layouts.app', ['title' => 'Create Payment Request']);
    }
}
