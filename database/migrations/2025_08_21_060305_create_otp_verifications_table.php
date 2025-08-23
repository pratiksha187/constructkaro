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
        Schema::create('otp_verifications', function (Blueprint $table) {
            $table->id();
            $table->enum('channel', ['sms','email']);
            $table->string('destination');        // phone (E.164) or email
            $table->string('code_hash');          // hashed OTP
            $table->timestamp('expires_at');
            $table->timestamp('verified_at')->nullable();
            $table->unsignedInteger('attempts')->default(0);
            $table->timestamp('last_sent_at')->nullable();
            $table->string('session_key')->nullable(); // optional, if you want tie to session/user
            $table->timestamps();

            $table->index(['channel','destination']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_verifications');
    }
};
