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
        Schema::create('t_po', function (Blueprint $table) {
            $table->id();
            $table->string('no_seri', 10);
            $table->string('spk', 200);
            $table->string('po', 100)->nullable();
            $table->string('so', 100)->nullable();
            $table->date('tgl_po')->nullable();
            $table->string('tipe', 50)->nullable();
            $table->string('kode', 50)->nullable();
            $table->string('nama')->nullable();
            $table->string('dc', 100)->nullable();
            $table->string('idm', 150)->nullable();
            $table->string('subkon', 150)->nullable();
            $table->string('bap', 150)->nullable();
            $table->string('kf_15', 5)->default(0);
            $table->string('kf_20', 5)->default(0);
            $table->string('kf_23', 5)->default(0);
            $table->string('kf_26', 5)->default(0);
            $table->string('kf_34', 5)->default(0);
            $table->string('kf_50', 5)->default(0);
            $table->string('kf_70', 5)->default(0);
            $table->string('kf_100', 5)->default(0);
            $table->string('kf_120', 5)->default(0);
            $table->date('start')->nullable();
            $table->date('due')->nullable();
            $table->string('sj', 50)->nullable();
            $table->string('cabut', 100)->nullable();
            $table->string('lok', 50)->nullable();
            $table->string('harga_sewa', 20)->nullable();
            $table->text('ket')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_po');
    }
};
