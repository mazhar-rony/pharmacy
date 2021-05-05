<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCreditorPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creditor_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('creditor_id');
            $table->date('payment_date');
            $table->string('payment_type');
            $table->decimal('paid', 13, 4);
            $table->timestamps();

            $table->foreign('creditor_id')
                ->references('id')
                ->on('creditors')
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
        Schema::dropIfExists('creditor_payments');
    }
}
