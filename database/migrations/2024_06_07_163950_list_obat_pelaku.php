<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ListObatPelaku extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        Schema::create('list_obat_pelaku', function (Blueprint $table) {
            $table->uuid('list_obat_pelaku_id')->primary();
            $table->uuid('batch_id');
            $table->uuid('pelaku_id');
            $table->integer('stok')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement('ALTER TABLE list_obat_pelaku ALTER COLUMN list_obat_pelaku_id SET DEFAULT uuid_generate_v4();');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_obat_pelaku');
    }
}
