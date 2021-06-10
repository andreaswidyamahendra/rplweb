<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\mhs;
use DB;
use Session;
use Symfony\Component\Console\Input\Input;
use App\Post;

class DosenController extends Controller
{
    //public function home(){
    //"Ini Home untuk Dosen & Koor";
    //return view('dosenHome');
    //}

    public function BimbinganKp()
    {
        $myString = auth()->user()->email;
        $nama_login = auth()->user()->name;
        $namaDosen = DB::table('dosen')->select('namaDosen')
            ->where('email', $myString)
            ->get();
        $nik = DB::table('dosen')->select('nik')
            ->where('email', $myString)
            ->orWhere('namaDosen', $nama_login)
            ->get();
        $ujian = DB::table('ujian')
            ->leftJoin('kp', 'ujian.idKp', '=', 'kp.idKp')
            ->get();
        $data = DB::table('registrasi')
            ->join('mahasiswa', 'mahasiswa.nim', '=', 'registrasi.nim')
            ->join('kp', 'registrasi.idReg', '=', 'kp.idReg')
            ->select(DB::raw('registrasi.nim,mahasiswa.nama,registrasi.idReg,
            kp.judul,kp.lembaga,kp.nik,kp.idKp,kp.pengajuanUjian'))
            ->get();
        $dafPengajuan = DB::table('ujian')
            ->join('kp', 'ujian.idKp', '=', 'kp.idKp')
            ->join('mahasiswa', 'ujian.nim', '=', 'mahasiswa.nim')
            ->select(DB::raw('ujian.idKp,ujian.nim,mahasiswa.nama,kp.nik,kp.pengajuanUjian'))
            ->get();
        return view('dosen.BimbinganKp', [
            'nik' => $nik, 'namaDosen' => $namaDosen,
            'data' => $data, 'dafPengajuan' => $dafPengajuan, 'ujian' => $ujian
        ]);
    }

    public function setUjian($idKp, $nim)
    {
        $id = DB::table('ujian')->insertGetId([
            'idKp' => $idKp,
            'nim' => $nim
        ]);
        $pengajuan = DB::table('kp')
            ->where('idKp', $idKp)
            ->update(['pengajuanUjian' => 1]);
        return redirect('/dosen/BimbinganKp');
    }

    public function UjianKp()
    {
        $myString = auth()->user()->email;
        $namaDosen = DB::table('dosen')->select('namaDosen')
            ->where('email', $myString)
            ->get();
        $nik = DB::table('dosen')->select('nik')
            ->where('email', $myString)
            ->get();
        $dafUjian = DB::table('ujian')
            ->join('kp', 'ujian.idKp', '=', 'kp.idKp')
            ->join('mahasiswa', 'ujian.nim', '=', 'mahasiswa.nim')
            ->join('dosen', 'ujian.nik', '=', 'dosen.nik')
            ->join('ruang', 'ujian.idRuang', '=', 'ruang.idRuang')
            ->select(DB::raw('ujian.idKp,ujian.nim,ujian.idRuang,kp.nik,
                ruang.namaRuang,dosen.namaDosen,ujian.tglUjian,ujian.jamUjian,
                mahasiswa.nama,kp.judul,kp.lembaga'))
            ->get();
        $dafPenguji = DB::table('ujian')
            ->join('kp', 'ujian.idKp', '=', 'kp.idKp')
            ->join('mahasiswa', 'ujian.nim', '=', 'mahasiswa.nim')
            ->join('dosen', 'kp.nik', '=', 'dosen.nik')
            ->join('ruang', 'ujian.idRuang', '=', 'ruang.idRuang')
            ->select(DB::raw('ujian.idKp, ujian.nim, ujian.idRuang, ujian.nik,
                ruang.namaRuang, dosen.namaDosen, ujian.tglUjian, ujian.jamUjian,
                mahasiswa.nama,kp.judul,kp.lembaga'))
            ->get();
        return view('dosen.UjianKp', ['nik' => $nik, 'namaDosen' => $namaDosen, 'dafUjian' => $dafUjian, 'dafPenguji' => $dafPenguji]);
    }
}
