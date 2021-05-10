<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProprietorTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proprietor_transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('proprietor_id');
            $table->date('transaction_date');
            $table->string('description')->nullable();
            $table->decimal('deposite', 13, 4)->default(0);
            $table->decimal('withdraw', 13, 4)->default(0);
            $table->timestamps();

            $table->foreign('proprietor_id')
                ->references('id')
                ->on('proprietors')
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
        Schema::dropIfExists('proprietor_transactions');
    }
}
