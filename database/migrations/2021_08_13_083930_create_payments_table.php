<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vnp_Amount');
            $table->string('vnp_BankCode',255)->nullable();
            $table->string('vnp_BankTranNo',255)->nullable();
          //  $table->string('vnp_CardType',255)->nullable();
            $table->text('vnp_OrderInfo')->nullable();
            $table->timestamp('vnp_PayDate',0)->nullable();
            $table->string('vnp_ResponseCode',255)->nullable();
            $table->string('vnp_TransactionNo',255)->nullable();
            $table->string('vnp_TxnRef',255)->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('point_id')->unsigned()->nullable();
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
        Schema::dropIfExists('payments');
    }
}
