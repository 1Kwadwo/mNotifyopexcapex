<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Staff',
                'slug' => 'staff',
                'description' => 'Regular employee who can submit invoices'
            ],
            [
                'name' => 'Finance Manager',
                'slug' => 'finance_manager',
                'description' => 'Finance manager who reviews and approves invoices, creates budgets'
            ],
            [
                'name' => 'CEO',
                'slug' => 'ceo',
                'description' => 'Chief Executive Officer who provides final approval'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
