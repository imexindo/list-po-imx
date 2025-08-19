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
        Schema::create('m_contract', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('code', 10)->nullable();
            $table->integer('year', 4)->nullable();
            $table->integer('group_id', 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_contract');
    }
};
