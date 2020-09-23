<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Expert;
class ExpertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Expert::class, 10)->create();
    }
}
