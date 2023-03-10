<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name",255);
            $table->string("slug",255);
            $table->integer("price")->nullable();
            $table->tinyInteger("sale")->default(0);
            $table->tinyInteger("hot")->default(0);
            $table->tinyInteger("pay")->default(0)->nullable();
            $table->tinyInteger("number")->default(0)->nullable();
            $table->integer("warranty")->nullable();
            $table->integer("view")->default(0)->nullable();
            $table->text("description")->nullable();
            $table->string("avatar_path",255)->nullable();
            $table->string("description_seo",255)->nullable();
            $table->string("title_seo",255)->nullable();
            $table->longText("content")->nullable();
            $table->tinyInteger("active")->default(1);
            $table->bigInteger("category_id")->unsigned();
            //  $table->foreign('category_id')->references('id')->on('categoriesproduct')->onDelete('cascade');
            $table->bigInteger("suppiler_id")->unsigned();
            //  $table->foreign('suppiler_id')->references('id')->on('categoriesarticles')->onDelete('cascade');
            $table->bigInteger("admin_id")->unsigned();
            //  $table->foreign('author_id')->references('id')->on('admins')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
