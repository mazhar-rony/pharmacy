<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('invoice_no');
            $table->date('date');
            $table->string('payment_type');
            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->decimal('amount', 13, 4);
            $table->decimal('discount', 13, 4)->default(0);
            $table->decimal('total_amount', 13, 4);
            $table->decimal('paid', 13, 4);
            $table->decimal('due', 13, 4);
            $table->decimal('profit', 13, 4);
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
        Schema::dropIfExists('invoices');
    }
}
