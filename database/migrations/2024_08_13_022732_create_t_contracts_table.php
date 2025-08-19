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
        Schema::create('t_contracts', function (Blueprint $table) {
            $table->id();
            $table->string('so', 50)->nullable();
            $table->string('spk', 50)->nullable();
            $table->date('tgl_bap')->nullable();
            $table->date('tgl_cabut')->nullable();
            $table->date('tgl_habis_sewa')->nullable();
            $table->string('kode', 50)->nullable();
            $table->string('nama', 50)->nullable();
            $table->string('dc', 50)->nullable();
            $table->string('lok', 50)->nullable();
            $table->string('npwp', 50)->nullable();
            $table->decimal('total', 15)->nullable();
            $table->string('nnpwp', 50)->nullable();
            $table->string('tipe', 50)->nullable();
            $table->string('ref', 50)->nullable();
            $table->text('anpwp')->nullable();
            $table->text('alamat')->nullable();
            $table->text('ket')->nullable();
            $table->integer('tagihan', 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->string('kf_00', 5)->default(0);
            $table->string('kf_15', 5)->default(0);
            $table->string('kf_20', 5)->default(0);
            $table->string('kf_23', 5)->default(0);
            $table->string('kf_26', 5)->default(0);
            $table->string('kf_34', 5)->default(0);
            $table->string('kf_50', 5)->default(0);
            $table->string('kf_70', 5)->default(0);
            $table->string('kf_100', 5)->default(0);
            $table->string('kf_120', 5)->default(0);
            $table->string('sd_70', 5)->default(0);
            $table->string('sd_90', 5)->default(0);
            $table->string('sd_120', 5)->default(0);
            $table->string('db_60', 5)->default(0);
            $table->string('db_80', 5)->default(0);
            $table->string('db_100', 5)->default(0);
            $table->string('db_150', 5)->default(0);
            $table->string('db_200', 5)->default(0);
            $table->string('kode_idm', 10)->nullable();
            $table->integer('contract_id')->nullable();
            $table->integer('group_contract_id')->nullable();
            $table->string('region_id', 20)->nullable();
            $table->string('group_name', 100)->nullable();
            $table->string('total_pk', 20)->nullable();
            $table->string('total_sap', 20)->nullable();
            $table->string('user_id', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_contracts');
    }
};
