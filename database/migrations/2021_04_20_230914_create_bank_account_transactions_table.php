<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_account_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bank_account_id');
            $table->date('transaction_date');
            $table->string('description')->nullable();
            $table->decimal('deposite', 13, 4)->default(0);
            $table->decimal('withdraw', 13, 4)->default(0);
            $table->decimal('interest', 13, 4)->default(0);
            $table->decimal('balance', 13, 4)->default(0);
            $table->timestamps();

            $table->foreign('bank_account_id')
                ->references('id')
                ->on('bank_accounts')
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
        Schema::dropIfExists('bank_account_transactions');
    }
}
