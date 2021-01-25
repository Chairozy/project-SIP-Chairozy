<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('cover');
            $table->integer('jumlah');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->integer('terbit');
            $table->integer('tebal_buku');
            $table->integer('harga');
            $table->integer('harga_sebelumnya');
            $table->timestamps();
        });

        Schema::create('log_penambah_buku', function (Blueprint $table) {
            $table->id();
            $table->integer('pengurus_id');
            $table->integer('buku_id');
            $table->string('judul');
            $table->string('jumlah');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->integer('terbit');
            $table->integer('tebal_buku');
            $table->integer('harga');
            $table->text('keterangan');
            $table->text('catatan');
            $table->timestamps();
        });

        Schema::create('log_pengurangan_buku', function (Blueprint $table) {
            $table->id();
            $table->integer('pengurus_id');
            $table->integer('buku_id');
            $table->string('jumlah');
            $table->enum('kondisi', ['bagus', 'baik', 'lecet', 'jelek', 'rusak']);
            $table->text('keterangan');
            $table->text('catatan');
            $table->timestamps();
        });

        Schema::create('kondisi_buku', function (Blueprint $table) {
            $table->id();
            $table->integer('pengurus_id');
            $table->integer('buku_id');
            $table->string('judul');
            $table->integer('bagus');
            $table->integer('baik');
            $table->integer('lecet');
            $table->integer('jelek');
            $table->integer('rusak');
            $table->text('keterangan');
            $table->text('catatan');
            $table->timestamps();
        });

        Schema::create('log_kondisi_buku', function (Blueprint $table) {
            $table->id();
            $table->integer('pengurus_id');
            $table->integer('buku_id');
            $table->string('judul');
            $table->text('log');
            $table->timestamps();
        });

        Schema::create('buku_operasi', function (Blueprint $table) {
            $table->id();
            $table->integer('pengurus_id');
            $table->integer('buku_id');
            $table->string('peminjam_id');
            $table->string('kondisi_pinjam');
            $table->date('tgl_pinjam');
            $table->integer('durasi_pinjam');
            $table->date('tgl_kembali');
            $table->string('kondisi_kembali');
            $table->text('keterangan');
            $table->text('catatan');
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
        Schema::dropIfExists('buku');
    }
}
