<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Super Administrator',
                'guard_name' => 'web',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Administrator',
                'guard_name' => 'web',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Registrar',
                'guard_name' => 'web',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Student',
                'guard_name' => 'web',
                'created_at' => Carbon::now()
            ]
        ];
        
        DB::table('roles')->insert($data);
    }
}
