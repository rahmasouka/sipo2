<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TransaksiObatDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('transaksi_detail', function (Blueprint $table) {
            $table->uuid('transaksi_detail_id')->primary();
            $table->uuid('transaksi_id');
            $table->uuid('batch_id');
            $table->uuid('pelaku_id');
            $table->string('jenis_trx')->nullable();
            $table->integer('jumlah')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE transaksi_detail ALTER COLUMN transaksi_detail_id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_detail');
    }
}
