<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patient_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('medical_record_id')->nullable();
            $table->string('file_name');
            $table->text('file_path');
            $table->string('file_type');
            $table->unsignedBigInteger('file_size');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('medical_record_id')->references('id')->on('medical_records')->nullOnDelete();
            $table->index(['patient_id', 'medical_record_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patient_attachments');
    }
};
