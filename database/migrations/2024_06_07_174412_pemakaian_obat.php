<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class PemakaianObat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('pemakaian_obat', function (Blueprint $table) {
            $table->uuid('pemakaian_obat_id')->primary();
            $table->uuid('batch_id');
            $table->uuid('pelaku_id');
            $table->integer('terpakai')->nullable();
            $table->string('catatan')->nullable();
            $table->string('')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE pemakaian_obat ALTER COLUMN pemakaian_obat_id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
