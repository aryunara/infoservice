<?php

namespace Database\Seeders;

use App\Models\LeadStatus;
use Illuminate\Database\Seeder;

class LeadStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeadStatus::create(['code' => 'new', 'title' => 'новый']);
        LeadStatus::create(['code' => 'in progress', 'title' => 'в работе']);
        LeadStatus::create(['code' => 'completed', 'title' => 'завершен']);
    }
}
