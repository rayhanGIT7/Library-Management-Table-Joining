<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_checkout', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('book_id');
            $table->string('checkout_date');
            $table->string('expected_return_date');
            $table->string('return_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_checkout');
    }
};
