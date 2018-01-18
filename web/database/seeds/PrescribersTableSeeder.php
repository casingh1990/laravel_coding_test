<?php

use Illuminate\Database\Seeder;

class PrescribersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Prescriber::class, 1000)->create();
    }
}
