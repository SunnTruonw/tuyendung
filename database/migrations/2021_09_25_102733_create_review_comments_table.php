<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->text('content');
            $table->string("image_path",255)->nullable();
            $table->bigInteger('review_id')->unsigned();
            $table->string('name',191)->nullable();
            $table->string('email',191)->nullable();
            $table->string('phone',191)->nullable();
            $table->foreign('review_id')->references('id')->on('reviews')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_comments');
    }
}
