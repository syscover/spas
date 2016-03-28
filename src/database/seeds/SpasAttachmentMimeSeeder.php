<?php

use Illuminate\Database\Seeder;
use Syscover\Pulsar\Models\AttachmentMime;

class SpasAttachmentMimeSeeder extends Seeder
{
    public function run()
    {
        AttachmentMime::insert([
            ['resource_id_019' => 'spas-spa', 'mime_019' => 'image/jpeg'],
            ['resource_id_019' => 'spas-spa', 'mime_019' => 'image/png']
        ]);
    }
}

/*
 * Command to run:
 * php artisan db:seed --class="SpasAttachmentMimeSeeder"
 */