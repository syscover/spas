<?php

use Illuminate\Database\Seeder;
use Syscover\Pulsar\Models\Resource;

class SpasResourceTableSeeder extends Seeder {

    public function run()
    {
        Resource::insert([
            ['id_007' => 'spas',                'name_007' => 'Spas Package', 'package_id_007' => '14'],
            ['id_007' => 'spas-spa',            'name_007' => 'Spas',         'package_id_007' => '14'],
        ]);
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="SpasResourceTableSeeder"
 */