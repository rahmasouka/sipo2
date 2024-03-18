<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Obat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('obat', function (Blueprint $table) {
            $table->uuid('obat_id')->primary();
            $table->uuid('satuan_id')->nullable();
            $table->string('kode_obat')->nullable();
            $table->string('nama_obat')->nullable();
            $table->string('kategori_obat')->nullable();
            $table->string('jenis_obat')->nullable();
            $table->string('merk')->nullable();
            $table->string('stok_terkini')->nullable();
            $table->integer('harga_beli')->nullable();
            $table->integer('harga_jual')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE obat ALTER COLUMN obat_id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('obat');
    }
}
