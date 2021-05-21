<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankLoanTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_loan_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bank_loan_id');
            $table->date('emi_date');
            $table->string('payment_type');
            $table->integer('emi_no');
            $table->decimal('emi_amount', 13, 4);
            $table->timestamps();

            $table->foreign('bank_loan_id')
                ->references('id')
                ->on('bank_loans')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bank_loan_transactions');
    }
}
