<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Permintaan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('permintaan', function (Blueprint $table) {
            $table->uuid('permintaan_id')->primary();
            $table->uuid('batch_id');
            $table->string('surat_permintaan')->nullable();
            $table->string('pelaku_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE permintaan ALTER COLUMN permintaan_id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permintaan');
    }
}
