<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use dosen;
use kp;
use mahasiswa;
use periode;
use permintaan_ujian;
use praKp;
use registrasi;
use ruang;
use surat;
use ujian;
use users;


class rpl extends Model
{
    protected $table = array(
        'dosen', 'kp', 'mahasiswa', 'periode', 'permintaan_ujian', 'praKp',
        'registrasi', 'ruang', 'surat', 'ujian', 'users'
    );
}
