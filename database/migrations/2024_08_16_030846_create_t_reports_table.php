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
        Schema::create('t_reports', function (Blueprint $table) {
            $table->id();
            $table->string('spk');
            $table->integer('total_spk');
            $table->integer('tgl_bap');
            $table->integer('db_60');
            $table->integer('db_80');
            $table->integer('db_100');
            $table->integer('db_150');
            $table->integer('db_200');
            $table->integer('sd_70');
            $table->integer('sd_90');
            $table->integer('sd_120');
            $table->integer('kf_00');
            $table->integer('kf_15');
            $table->integer('kf_20');
            $table->integer('kf_23');
            $table->integer('kf_26');
            $table->integer('kf_34');
            $table->integer('kf_50');
            $table->integer('kf_70');
            $table->integer('kf_100');
            $table->integer('kf_120');
            $table->string('total_biaya');
            $table->integer('region_id', 20);
            $table->integer('contacts_id', 5);
            $table->integer('group_contract_id', 5)->nullable();
            $table->integer('group_name', 100)->nullable();
            $table->integer('tagihan', 2)->default(1);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_reports');
    }
};
