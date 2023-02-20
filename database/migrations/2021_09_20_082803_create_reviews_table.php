<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string("name",191);
            $table->string("slug",191);
            $table->string("link",191)->nullable();
            $table->integer("view")->default(0)->nullable();
            $table->string("avatar_path",191)->nullable();
            $table->longText("content")->nullable();
            $table->text("description")->nullable();
            $table->tinyInteger("active")->default(1);
            $table->string("description_seo",191)->nullable();
            $table->string("keyword_seo",191)->nullable();
            $table->string("title_seo",191)->nullable();
            $table->bigInteger("user_id")->unsigned();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
