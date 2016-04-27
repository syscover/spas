<?php

use Illuminate\Database\Seeder;
use Syscover\Pulsar\Models\Package;

class SpasPackageTableSeeder extends Seeder
{
    public function run()
    {
        Package::insert([
            ['id_012' => '14', 'name_012' => 'Spas Package', 'folder_012' => 'spas', 'sorting_012' => 14, 'active_012' => false]
        ]);
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="SpasPackageTableSeeder"
 */