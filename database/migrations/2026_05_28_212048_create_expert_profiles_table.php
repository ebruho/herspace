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
        Schema::create('expert_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            $table->string('title')->nullable();           // "Психолог", "Career Coach"
            $table->string('specialization')->nullable();
            $table->text('education')->nullable();
            $table->integer('years_of_experience')->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('verification_status')->default('pending'); // pending, approved, rejected
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expert_profiles');
    }
};
