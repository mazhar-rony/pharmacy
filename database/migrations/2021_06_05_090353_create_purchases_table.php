<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('purchase_no');
            $table->date('date');
            $table->string('payment_type');
            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->decimal('amount', 13, 4);
            $table->decimal('discount', 13, 4)->default(0);
            $table->decimal('total_amount', 13, 4);
            $table->decimal('paid', 13, 4);
            $table->decimal('due', 13, 4);
            $table->text('description')->nullable();
            $table->boolean('is_paid')->default(0)->comment('0=Pending,1=Paid');
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
        Schema::dropIfExists('purchases');
    }
}
