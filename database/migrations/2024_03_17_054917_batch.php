<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Batch extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('batch', function (Blueprint $table) {
            $table->uuid('batch_id')->primary();
            $table->uuid('obat_id');
            $table->string('kode_batch')->nullable();
            $table->string('expired')->nullable();
            $table->string('jenis')->nullable();
            $table->string('keterangan')->nullable();
            $table->dateTime('tanggal_pengadaan')->nullable();
            $table->year('tahun_pengadaan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE batch ALTER COLUMN batch_id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batch');
    }
}
