<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->integer('year');
            $table->integer('month');
            $table->date('date');
            $table->string('payment_type');
            $table->unsignedBigInteger('bank_account_id')->nullable();
            $table->decimal('salary', 13, 4)->default(0);
            $table->decimal('advance_deduct', 13, 4)->default(0);
            $table->decimal('bonus', 13, 4)->default(0);
            $table->timestamps();

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
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
        Schema::dropIfExists('employee_payments');
    }
}
