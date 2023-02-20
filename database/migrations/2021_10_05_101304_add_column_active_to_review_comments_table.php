<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnActiveToReviewCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('review_comments', function (Blueprint $table) {
            //
            $table->tinyInteger('active')->default(0)->nullable();
        });
        Schema::table('product_comments', function (Blueprint $table) {
            //
            $table->tinyInteger('active')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('review_comments', function (Blueprint $table) {
            //
            $table->dropColumn('active');
        });
        Schema::table('product_comments', function (Blueprint $table) {
            //
            $table->dropColumn('active');
        });
    }
}
