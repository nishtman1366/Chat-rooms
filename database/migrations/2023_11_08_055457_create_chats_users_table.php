<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chats_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Chat::class)->constrained('chats')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\User::class)->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats_users');
    }
};
