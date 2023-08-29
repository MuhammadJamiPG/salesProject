<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class SalesHeadSeeder extends Seeder
{
    public function run(): void
    {
        $heads = [
            [
                'name' => 'Head',
                'email' => 'saleshead@gmail.com',
                'password' => bcrypt('123456'),
                'role' => User::SalesHead,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Sales',
                'email' => 'head@gmail.com',
                'password' => bcrypt('123456'),
                'role' => User::SalesHead,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'John',
                'email' => 'john@gmail.com',
                'password' => bcrypt('123456'),
                'role' => User::SalesHead,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ];

        foreach ($heads as $key => $head) {
            User::insert($head);
        }
    }
}