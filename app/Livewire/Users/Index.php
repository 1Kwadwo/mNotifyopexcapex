<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Models\Role;
use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class Index extends Component
{
    use WithPagination;

    public $showCreateModal = false;
    public $name = '';
    public $email = '';
    public $password = '';
    public $department_id = '';

    public function createUser()
    {
        // Only Finance Managers can create users
        if (!auth()->user()->isFinanceManager()) {
            abort(403);
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'email_verified_at' => now(),
        ]);

        // Assign Staff role
        $user->assignRole('staff');

        session()->flash('message', 'User created successfully!');

        $this->reset(['name', 'email', 'password', 'department_id', 'showCreateModal']);
    }

    public function render()
    {
        $users = User::with('roles')->latest()->paginate(15);
        $departments = Department::all();

        return view('livewire.users.index', [
            'users' => $users,
            'departments' => $departments,
        ])->layout('components.layouts.app', ['title' => 'Users']);
    }
}
