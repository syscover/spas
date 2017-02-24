<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Syscover\Pulsar\Libraries\DBLibrary;

class SpasUpdateV2 extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(! Schema::hasColumn('014_180_spa', 'booking_data_180'))
        {
            Schema::table('014_180_spa', function (Blueprint $table) {
                $table->string('booking_data_180')->nullable()->after('longitude_180');
            });
        }

        if(! Schema::hasColumn('014_180_spa', 'booking_email_180'))
        {
            Schema::table('014_180_spa', function (Blueprint $table) {
                $table->string('booking_email_180')->nullable()->after('booking_data_180');
            });
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){}
}