<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class StokObat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('stok_obat', function (Blueprint $table) {
            $table->uuid('stok_obat_id')->primary();
            $table->uuid('batch_id');
            $table->uuid('obat_id');
            $table->integer('stok')->nullable();
            $table->string('detail')->nullable();
            $table->string('ket')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE stok_obat ALTER COLUMN stok_obat_id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stok_obat');
    }
}
