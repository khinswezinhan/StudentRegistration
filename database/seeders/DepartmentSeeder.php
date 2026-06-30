<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create(['department_name' => 'FCS']);
        Department::create(['department_name' => 'FCST']);
        Department::create(['department_name' => 'FIS']);
        Department::create(['department_name' => 'ITSM']);
        Department::create(['department_name' => 'Department of Computing']);
        Department::create(['department_name' => 'English Department']);
        Department::create(['department_name' => 'Physics Department']);
        Department::create(['department_name' => 'Myanmar Department']);
    }
}
