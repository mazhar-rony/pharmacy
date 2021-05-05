<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDebtorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('debtors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->string('description')->nullable();
            $table->date('debit_date');
            $table->decimal('debit_amount', 13, 4);
            $table->decimal('paid', 13, 4)->default(0);
            $table->decimal('consession', 13, 4)->default(0);
            $table->decimal('due', 13, 4);
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
        Schema::dropIfExists('debtors');
    }
}
