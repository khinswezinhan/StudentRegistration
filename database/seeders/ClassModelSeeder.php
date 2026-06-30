<?php

namespace Database\Seeders;

use App\Models\ClassModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $classes = ['1CST', '2CS', '2CT', '3CS', '3CT', '4CS', '4CT', '5CS', '5CT'];
        
        foreach ($classes as $class) {
            ClassModel::firstOrCreate([
                'name' => $class
            ]);
        }
    }
}
