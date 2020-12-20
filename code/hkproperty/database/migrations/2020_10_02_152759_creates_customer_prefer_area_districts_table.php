<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatesCustomerPreferAreaDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_prefer_area_districts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_prefer_id')->onDelete('cascade')->constrained('customer_prefers');
            $table->foreignId('area_id')->onDelete('set null')->nullable()->constrained('areas');
            $table->foreignId('district_id')->onDelete('set null')->nullable()->constrained('districts');
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
        Schema::dropIfExists('customer_prefer_area_districts');
    }
}
