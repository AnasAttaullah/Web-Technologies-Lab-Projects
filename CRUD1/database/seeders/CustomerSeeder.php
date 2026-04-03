<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '+1234567890',
                'address' => '123 Main St, New York, NY 10001',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '+1234567891',
                'address' => '456 Oak Ave, Los Angeles, CA 90001',
            ],
            [
                'name' => 'Michael Johnson',
                'email' => 'michael@example.com',
                'phone' => '+1234567892',
                'address' => '789 Pine Rd, Chicago, IL 60601',
            ],
            [
                'name' => 'Emily Brown',
                'email' => 'emily@example.com',
                'phone' => '+1234567893',
                'address' => '321 Elm St, Houston, TX 77001',
            ],
            [
                'name' => 'David Wilson',
                'email' => 'david@example.com',
                'phone' => '+1234567894',
                'address' => '654 Maple Dr, Phoenix, AZ 85001',
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
