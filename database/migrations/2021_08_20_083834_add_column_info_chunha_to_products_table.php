<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInfoChunhaToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->string('phone_chunha',255)->nullable();
            $table->string('email_chunha',255)->nullable();
            $table->string('name_chunha',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            //
            $table->dropColumn('phone_chunha');
            $table->dropColumn('email_chunha');
            $table->dropColumn('name_chunha');
        });
    }
}
