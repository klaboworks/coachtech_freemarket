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
        Schema::create('deals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->cascadeOnDelete();
            $table->integer('buyer_id')->nullable();
            $table->integer('seller_id')->nullable();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete(); // 送信者
            $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete(); // 受信者
            $table->text('deal_message');
            $table->string('additional_image')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deals');
    }
};
