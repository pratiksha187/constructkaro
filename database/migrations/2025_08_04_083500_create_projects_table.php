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
       Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('construction_type_id')->nullable();
            $table->unsignedBigInteger('project_type_id')->nullable();
            $table->boolean('site_ready')->default(false);

            // Land details
            $table->string('land_location')->nullable();
            $table->string('survey_number')->nullable();
            $table->string('land_type')->nullable();
            $table->string('land_area')->nullable();
            $table->string('land_unit')->nullable();

            // Documents
            $table->boolean('arch_drawings')->default(false);
            $table->boolean('struct_drawings')->default(false);
            $table->boolean('has_boq')->default(false);
            $table->string('boq_file')->nullable();

            // Timeline and Budget
            $table->date('expected_start')->nullable();
            $table->string('project_duration')->nullable();
            $table->string('budget_range')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
