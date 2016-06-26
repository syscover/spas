<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SpasCreateTableSpaLang extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(! Schema::hasTable('014_181_spa_lang'))
		{
			Schema::create('014_181_spa_lang', function (Blueprint $table) {
				$table->engine = 'InnoDB';

				$table->integer('id_181')->unsigned();
				$table->string('lang_id_181', 2);
				$table->string('description_title_181')->nullable();
				$table->text('description_181')->nullable();
				$table->text('treatments_181')->nullable();
				
				$table->foreign('id_181', 'fk01_014_181_spa_lang')->references('id_180')->on('014_180_spa')
					->onDelete('cascade')->onUpdate('cascade');
				$table->foreign('lang_id_181', 'fk02_014_181_spa_lang')->references('id_001')->on('001_001_lang')
					->onDelete('restrict')->onUpdate('cascade');

				$table->primary(['id_181', 'lang_id_181'], 'pk01_014_181_spa_lang');
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
		if(Schema::hasTable('014_181_spa_lang'))
		{
			Schema::drop('014_181_spa_lang');
		}
	}
}