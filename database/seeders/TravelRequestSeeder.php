<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TravelRequest;

class TravelRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TravelRequest::factory()->count(10)->create();
    }
}
