<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatesTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('package_id')->constrained('packages');
            $table->foreignId('transaction_type_id')->constrained('transaction_types');
            $table->bigInteger('transaction_amount');
            $table->date('transaction_date');
            $table->float('commission');
            $table->foreignId('facilitated_by')->nullable()->onDelete('set null')->constrained('users');
            $table->foreignId('customer_id')->nullable()->onDelete('set null')->constrained('customers');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
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
        Schema::dropIfExists('transactions');
    }
}
