<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_loans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bank_id');
            $table->unsignedBigInteger('branch_id');
            $table->string('account_type');
            $table->string('account_name');
            $table->string('account_number');
            $table->date('loan_date');
            $table->decimal('loan_amount', 13, 4);
            $table->decimal('emi_amount', 13, 4);
            $table->integer('total_emi');
            $table->integer('emi_given');
            $table->decimal('total_paid', 13, 4);

            $table->foreign('bank_id')
                ->references('id')
                ->on('banks')
                ->onDelete('cascade');

            $table->foreign('branch_id')
                ->references('id')
                ->on('bank_branches')
                ->onDelete('cascade');

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
        Schema::dropIfExists('bank_loans');
    }
}
