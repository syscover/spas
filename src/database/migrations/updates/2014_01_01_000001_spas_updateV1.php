<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Syscover\Pulsar\Libraries\DBLibrary;

class SpasUpdateV1 extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// change country_180
		DBLibrary::renameColumnWithForeignKey('014_180_spa', 'country_180', 'country_id_180', 'VARCHAR', 2, false, false, 'fk01_014_180_spa', '001_002_country', 'id_002');
		// change territorial_area_1_180
		DBLibrary::renameColumnWithForeignKey('014_180_spa', 'territorial_area_1_180', 'territorial_area_1_id_180', 'VARCHAR', 6, false, true, 'fk02_014_180_spa', '001_003_territorial_area_1', 'id_003');
		// change territorial_area_2_180
		DBLibrary::renameColumnWithForeignKey('014_180_spa', 'territorial_area_2_180', 'territorial_area_2_id_180', 'VARCHAR', 10, false, true, 'fk03_014_180_spa', '001_004_territorial_area_2', 'id_004');
		// change territorial_area_3_180
		DBLibrary::renameColumnWithForeignKey('014_180_spa', 'territorial_area_3_180', 'territorial_area_3_id_180', 'VARCHAR', 10, false, true, 'fk04_014_180_spa', '001_005_territorial_area_3', 'id_005');
		// change custom_field_group_180
		DBLibrary::renameColumnWithForeignKey('014_180_spa', 'custom_field_group_180', 'field_group_id_180', 'INT', 10, true, true, 'fk05_014_180_spa', '001_025_field_group', 'id_025');

		// change lang_181
		DBLibrary::renameColumnWithForeignKey('014_181_spa_lang', 'lang_181', 'lang_id_181', 'VARCHAR', 2, false, false, 'fk02_014_181_spa_lang', '001_001_lang', 'id_001');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){}
}