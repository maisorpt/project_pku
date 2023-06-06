<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add new columns
            DB::statement('ALTER TABLE users MODIFY COLUMN pob VARCHAR(255) AFTER gender');
            DB::statement('ALTER TABLE users MODIFY COLUMN prov_id INT AFTER gender');
            DB::statement('ALTER TABLE users MODIFY COLUMN city_id INT AFTER gender');
            DB::statement('ALTER TABLE users MODIFY COLUMN dis_id INT AFTER gender');
            DB::statement('ALTER TABLE users MODIFY COLUMN subdis_id INT AFTER gender');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Re-add removed columns
            $table->string('phone2');
            $table->string('bg_id');
            $table->string('state_id');
            $table->string('lga_id');
            $table->string('nal_id');

            // // Remove added columns
            $table->dropColumn('pob');
            $table->dropColumn('prov_id');
            $table->dropColumn('city_id');
            $table->dropColumn('dis_id');
            $table->dropColumn('subdis_id');
        });
    }
}
