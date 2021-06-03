<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('invoice_no');
            $table->date('date');
            $table->string('payment_type');
            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->decimal('amount', 9, 4);
            $table->decimal('paid', 9, 4);
            $table->text('description')->nullable();
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
        Schema::dropIfExists('return_products');
    }
}
