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
        Schema::create('vendor_types', function (Blueprint $table) {
            $table->id();
          
        $table->unsignedBigInteger('work_subtype_id');
        $table->string('name');
        $table->timestamps();

        $table->foreign('work_subtype_id')->references('id')->on('work_subtypes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_types');
    }
};
