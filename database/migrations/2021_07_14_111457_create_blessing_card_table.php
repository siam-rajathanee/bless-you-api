<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlessingCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blessing_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('donation_id')
                ->constrained('donations')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('card')->nullable();
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
        Schema::dropIfExists('blessing_cards');
    }
}
