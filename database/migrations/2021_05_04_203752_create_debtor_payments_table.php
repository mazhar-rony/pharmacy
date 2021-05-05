<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebtorPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debtor_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('debtor_id');
            $table->date('payment_date');
            $table->string('payment_type');
            $table->decimal('paid', 13, 4);
            $table->timestamps();

            $table->foreign('debtor_id')
                ->references('id')
                ->on('debtors')
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
        Schema::dropIfExists('debtor_payments');
    }
}
