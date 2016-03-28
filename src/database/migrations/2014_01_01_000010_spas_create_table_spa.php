<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SpasCreateTableSpa extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        if(! Schema::hasTable('014_180_spa'))
        {
            Schema::create('014_180_spa', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->increments('id_180')->unsigned();

                // custom
                $table->integer('custom_field_group_180')->unsigned()->nullable();

                // hotel related
                $table->integer('hotel_id_180')->unsigned()->nullable();

                // spa description
                $table->string('name_180');
                $table->string('slug_180')->nullable();
                $table->string('web_180')->nullable();
                $table->string('web_url_180')->nullable();
                $table->string('contact_180')->nullable();
                $table->string('email_180')->nullable();
                $table->string('phone_180')->nullable();
                $table->string('mobile_180')->nullable();
                $table->string('fax_180')->nullable();

                // access
                $table->boolean('active_180');

                // geolocation data
                $table->string('country_180', 2);
                $table->string('territorial_area_1_180', 6)->nullable();
                $table->string('territorial_area_2_180', 10)->nullable();
                $table->string('territorial_area_3_180', 10)->nullable();
                $table->string('cp_180')->nullable();
                $table->string('locality_180')->nullable();
                $table->string('address_180')->nullable();
                $table->string('latitude_180')->nullable();
                $table->string('longitude_180')->nullable();

                $table->string('data_lang_180')->nullable();
                $table->text('data_180')->nullable();

                // INDEX
                $table->index('slug_180', 'ix01_007_180_hotel');

                $table->foreign('country_180', 'fk01_007_180_hotel')->references('id_002')->on('001_002_country')
                    ->onDelete('restrict')->onUpdate('cascade');
                $table->foreign('territorial_area_1_180', 'fk02_007_180_hotel')->references('id_003')->on('001_003_territorial_area_1')
                    ->onDelete('restrict')->onUpdate('cascade');
                $table->foreign('territorial_area_2_180', 'fk03_007_180_hotel')->references('id_004')->on('001_004_territorial_area_2')
                    ->onDelete('restrict')->onUpdate('cascade');
                $table->foreign('territorial_area_3_180', 'fk04_007_180_hotel')->references('id_005')->on('001_005_territorial_area_3')
                    ->onDelete('restrict')->onUpdate('cascade');
                $table->foreign('custom_field_group_180', 'fk09_007_180_hotel')->references('id_025')->on('001_025_field_group')
                    ->onDelete('restrict')->onUpdate('cascade');
            });
        }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        if (Schema::hasTable('014_180_spa'))
        {
            Schema::drop('014_180_spa');
        }
	}
}