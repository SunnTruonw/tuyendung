<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAddressToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->bigInteger("city_id")->unsigned()->nullable();
            $table->bigInteger("district_id")->unsigned()->nullable();
            $table->bigInteger("commune_id")->unsigned()->nullable();
            $table->string("address_detail",255)->nullable();
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
            //
            $table->dropColumn("city_id");
            $table->dropColumn("district_id");
            $table->dropColumn("commune_id");
        });
    }
}
