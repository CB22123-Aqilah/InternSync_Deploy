<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personality_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('result_type');
            $table->text('result_description');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personality_assessments');
    }
};
