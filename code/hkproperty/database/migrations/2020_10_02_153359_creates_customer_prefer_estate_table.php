<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatesCustomerPreferEstateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_prefer_estate', function (Blueprint $table) {
            $table->foreignId('customer_prefer_area_district_id')->onDelete('cascade')->constrained('customer_prefer_area_districts');
            $table->foreignId('estate_id')->onDelete('cascade')->constrained('estates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_prefer_estate');
    }
}
