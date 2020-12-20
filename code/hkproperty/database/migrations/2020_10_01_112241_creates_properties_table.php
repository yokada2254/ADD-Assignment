<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatesPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('room')->default(0);
            $table->tinyInteger('store_room')->default(0)->unsigned();
            $table->tinyInteger('washroom')->default(0)->unsigned();
            $table->enum('open_kitchen', ['', '1'])->default('');
            $table->smallInteger('gross_size')->default(0)->unsigned();
            $table->smallInteger('roof_size')->default(0)->unsigned();
            $table->smallInteger('balcony_size')->default(0)->unsigned();
            $table->foreignId('estate_id')->nullable()->constrained('estates');
            $table->string('block')->nullable();
            $table->string('floor')->nullable();
            $table->string('flat')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();

            $table->unique(['estate_id', 'block', 'floor', 'flat']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property');
    }
}
