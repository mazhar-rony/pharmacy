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
            $table->unsignedInteger('invoice_no');
            $table->date('date');
            $table->decimal('amount', 9, 4);
            $table->decimal('discount', 9, 4)->default(0);
            $table->decimal('total_amount', 9, 4);
            $table->decimal('paid', 9, 4);
            $table->decimal('due', 9, 4);
            $table->decimal('profit', 9, 4);
            $table->text('description')->nullable();
            $table->boolean('status')->default(0)->comment('0=Paid,1=Pending');
            $table->integer('created_by');
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
