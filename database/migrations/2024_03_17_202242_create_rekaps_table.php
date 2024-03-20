<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekaps', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal');
            $table->string('afdeling');
            $table->integer('jumlah_hilang');
            $table->integer('jumlah_selamat');
            $table->text('ket');
            $table->unsignedBigInteger('kebun_id');
            $table->foreign('kebun_id')->references('id')->on('kebuns')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekaps');
    }
};
