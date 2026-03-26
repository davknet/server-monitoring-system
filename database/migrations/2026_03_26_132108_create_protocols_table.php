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
        Schema::create('protocols', function (Blueprint $table) {
            $table->id();
            $table->string('name');
             $table->string('protocol')->unique(); // e.g. http, ftp
            $table->text('description')->nullable(); // Details / explanation
            $table->string('type')->nullable();     // e.g. http, ftp, medical, internal
            $table->string('version')->nullable();  // e.g. v1, v2
            $table->boolean('is_active')->default(true); // status
            $table->json('config')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('protocols');
    }
};
