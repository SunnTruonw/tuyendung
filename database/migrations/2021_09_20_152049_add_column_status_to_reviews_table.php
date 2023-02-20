<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStatusToReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reviews', function (Blueprint $table) {
            //
            $table->tinyInteger('status')->default(0)->nullable();
            $table->string('address_nhan',191)->nullable();
            $table->string('phone_nhan',191)->nullable();
            $table->string('name_nhan',191)->nullable();
            $table->text('info_nhan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            //
            $table->dropColumn('status');
            $table->dropColumn('address_nhan');
            $table->dropColumn('phone_nhan');
            $table->dropColumn('name_nhan');
            $table->dropColumn('info_nhan');
        });
    }
}
