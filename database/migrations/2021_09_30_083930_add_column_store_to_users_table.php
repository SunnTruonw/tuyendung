<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStoreToUsersTable extends Migration
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
            $table->string('name_store',191)->nullable();
            $table->string('logo_store',191)->nullable();
            $table->string('address_store',191)->nullable();
            $table->tinyInteger('status_store')->nullable()->default(0);
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
            $table->dropColumn('name_store');
            $table->dropColumn('status_store');
            $table->dropColumn('logo_store');
        });
    }
}
