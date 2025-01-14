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
        Schema::create('links', function (Blueprint $table) {
            $table->id();
            $table->string('uid')->unique()->index();
            $table->timestamp('expired_date')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('links', function (Blueprint $table) {
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
