<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
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
                'name' => 'Manage Administrators',
                'guard_name' => 'web',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Manage Students',
                'guard_name' => 'web',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Manage Registrars',
                'guard_name' => 'web',
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Manage Announcements',
                'guard_name' => 'web',
                'created_at' => Carbon::now()
            ]
        ];

        DB::table('permissions')->insert($data);
    }
}
