<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('stock_additions', function (Blueprint $table) {
            $table->id();
            $table->integer('batch_id')->unsigned();
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            $table->integer('initial_amount');
            $table->integer('quantity_added');
            $table->integer('final_amount');
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_additions');
    }
};

