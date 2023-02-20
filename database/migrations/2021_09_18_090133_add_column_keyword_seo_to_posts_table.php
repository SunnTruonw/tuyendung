<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnKeywordSeoToPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->string('keyword_seo',191)->nullable();
        });
        Schema::table('category_posts', function (Blueprint $table) {
            //
            $table->string('keyword_seo',191)->nullable();
        });
        Schema::table('category_products', function (Blueprint $table) {
            //
            $table->string('keyword_seo',191)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            //
            $table->dropColumn('keyword_seo');
        });
        Schema::table('category_posts', function (Blueprint $table) {
            //
            $table->dropColumn('keyword_seo');
        });
        Schema::table('category_products', function (Blueprint $table) {
            //
            $table->dropColumn('keyword_seo');
        });
    }
}
