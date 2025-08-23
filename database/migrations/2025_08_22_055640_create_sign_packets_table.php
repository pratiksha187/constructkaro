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
        Schema::create('sign_packets', function (Blueprint $t) {
      $t->id();
      $t->string('ext_id')->nullable()->index();    // Leegality packet/invite/workflow run id
      $t->string('status')->default('created');
      $t->string('doc_name');
      $t->string('signer_email')->nullable();
      $t->string('signer_phone')->nullable();
      $t->json('meta')->nullable();
      $t->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sign_packets');
    }
};
