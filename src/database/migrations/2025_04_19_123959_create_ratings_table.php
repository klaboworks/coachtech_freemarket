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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rater_id')->constrained('users')->cascadeOnDelete()->comment('評価を行ったユーザー (購入者または出品者)');
            $table->foreignId('rated_user_id')->constrained('users')->cascadeOnDelete()->comment('評価されたユーザー (出品者または購入者)');
            $table->foreignId('purchase_id')->constrained()->cascadeOnDelete()->comment('評価が行われた取引');
            $table->tinyInteger('rating')->comment('評価点');
            $table->enum('role', ['buyer', 'seller'])->comment('評価を行ったユーザーの役割');
            $table->timestamps();

            $table->unique(['rater_id', 'rated_user_id', 'purchase_id', 'role'], 'unique_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
