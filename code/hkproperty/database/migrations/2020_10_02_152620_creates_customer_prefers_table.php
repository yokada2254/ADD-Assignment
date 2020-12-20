<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatesCustomerPrefersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_prefers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->onDelete('cascade')->constrained('customers');
            $table->foreignId('transaction_type_id')->onDelete('set null')->nullable()->constrained('transaction_types');
            $table->decimal('fm', 12, 1)->unsigned()->nullable();
            $table->decimal('to', 12, 1)->unsigned()->nullable();
            $table->bigInteger('room')->nullable();
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
        Schema::dropIfExists('customer_prefers');
    }
}
