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
        Schema::create('decision', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('ip_address');
            $table->unsignedBigInteger('server_id');
            // $table->string('protocol');
            $table->string('status');
            $table->timestamp('timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('decision');
    }
};
