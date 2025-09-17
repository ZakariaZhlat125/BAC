<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $years = ['السنة الاولى', 'السنةالثانية', 'السنة الثالثة', 'السنة الرابعة'];

        foreach ($years as $year) {
            Year::firstOrCreate(['name' => $year]);
        }
    }
}
