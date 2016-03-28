<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SpasTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->call(SpasPackageTableSeeder::class);
        $this->call(SpasResourceTableSeeder::class);
        $this->call(SpasAttachmentMimeSeeder::class);

        Model::reguard();
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="SpasTableSeeder"
 */