<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PermintaanDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('permintaan_detail', function (Blueprint $table) {
            $table->uuid('permintaan_detail_id')->primary();
            $table->uuid('permintaan_id');
            $table->uuid('batch_id');
            $table->integer('jumlah_permintaan')->nullable();
            $table->string('status')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE permintaan_detail ALTER COLUMN permintaan_detail_id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permintaan_detail');
    }
}
