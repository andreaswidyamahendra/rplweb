<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use \App\rpl;
use Symfony\Component\Console\Input\Input;
use App\Post;

class MahasiswaController extends Controller
{
    public function home()
    {
        return view('mahasiswa.home');
    }

    public function jadwal_ujian()
    {
        $myString = auth()->user()->email;
        $nama = DB::table('mahasiswa')->select('nama')
            ->where('email', $myString)
            ->get();
        $nim = DB::table('mahasiswa')->select('nim')
            ->where('email', $myString)
            ->get();
        $ujian = DB::table('ujian')
            ->join('ruang', 'ujian.idRuang', '=', 'ruang.idRuang')
            ->join('dosen', 'ujian.nik', '=', 'dosen.nik')
            ->select(DB::raw('ujian.idUjian, ujian.idRuang, ujian.nik, ruang.namaRuang, dosen.namaDosen,
                ujian.jamUjian, ujian.tglUjian'))
            ->orderBy('ujian.tglUjian')
            ->get();
        $dosbing = DB::table('kp')
            ->join('dosen', 'dosen.nik', '=', 'kp.nik')
            ->join('ujian', 'ujian.idKp', '=', 'kp.idKp')
            ->select(DB::raw('kp.idKp, kp.nik, kp.judul, dosen.namaDosen'))
            ->get();
        return view('mahasiswa.jadwalUjian', ['nim' => $nim, 'nama' => $nama, 'ujian' => $ujian, 
            'dosbing' => $dosbing]);
    }

    public function SuratKeterangan()
    {
        $myString = auth()->user()->email;
        $nama = auth()->user()->name;
        $nim_login = DB::table('mahasiswa')->select('nim')
            ->where('nama', $nama)
            ->orWhere('email', $myString)
            ->get();
        $dosenPembimbing = DB::table('dosen')
            ->join('kp', 'kp.nik', '=', 'dosen.nik')
            ->select(DB::raw('dosen.namaDosen, dosen.nik'))
            ->get();
        $perAktif = DB::table('periode')
            ->select('tahun', 'semester', 'aktif')
            ->where('aktif', '1')
            ->get();
        $data = DB::table('registrasi')
            ->join('surat', 'surat.idReg', '=', 'registrasi.idReg')
            ->join('periode', 'periode.idPeriode', '=', 'registrasi.idPeriode')
            ->select(DB::raw('registrasi.idReg, registrasi.idPeriode,periode.aktif,
                registrasi.nim, surat.lembaga, surat.statusSurat'))
            ->orderBy('registrasi.idReg')
            ->get();
        return view('mahasiswa.SuratKeterangan', [
            'data' => $data, 'nim_login' => $nim_login,
            'dosenPembimbing' => $dosenPembimbing, 'perAktif' => $perAktif
        ]);
    }

    public function AjukanSurat(Request $request)
    {
        $idPeriode = DB::table('periode')->select('idPeriode')
            ->where('semester', $request->semester)
            ->where('tahun', $request->tahun)
            ->get();

        $data = new rpl;
        if ($request->file('dokSurat')) {
            $file = $request->file('dokSurat');
            $nim = $request->nim;
            $ext = $file->getClientOriginalExtension();
            $nama_file = $request->nim . "." . $file->getClientOriginalExtension();
            $path = 'suratKeterangan';
            $file->getMimeType();
            $file->move($path, $nama_file);
            $data->file = $nama_file;
        }
        $id = DB::table('registrasi')->insertGetId(
            [
                'nim' => $request->nim,
                'idPeriode' => $idPeriode[0]->idPeriode,
                'semester' => $request->semester,
                'tahun' => $request->tahun
            ]
        );

        $surat = DB::table('surat')->insert(
            [
                'lembaga' => $request->lembaga,
                'idReg' => $id,
                'pimpinan' => $request->pimpinan,
                'noTelp' => $request->noTelp,
                'alamat' => $request->alamat,
                'fax' => $request->fax,
                'dokSurat' => $data->file
            ]
        );

        return redirect('mahasiswa/SuratKeterangan')->with('success', 'Surat Keterangan berhasil di ajukan!');
    }

    public function PraKp()
    {
        $myString = auth()->user()->email;
        $nama = auth()->user()->name;
        $nim_login = DB::table('mahasiswa')->select('nim')
            ->where('nama', $nama)
            ->orWhere('email', $myString)
            ->get();
        $dosenPembimbing = DB::table('dosen')
            ->join('kp', 'kp.nik', '=', 'dosen.nik')
            ->select(DB::raw('dosen.namaDosen, dosen.nik'))
            ->get();
        $perAktif = DB::table('periode')
            ->select('tahun', 'semester', 'aktif')
            ->where('aktif', '1')
            ->get();
        $data = DB::table('registrasi')
            ->join('praKp', 'praKp.idReg', '=', 'registrasi.idReg')
            ->join('periode', 'periode.idPeriode', '=', 'registrasi.idPeriode')
            ->select(DB::raw('registrasi.nim, praKp.judul, praKp.lembaga, praKp.statusPraKp,
                registrasi.idPeriode,periode.aktif,registrasi.idReg'))
            ->orderBy('registrasi.idReg')
            ->get();
        return view('mahasiswa.PraKp', [
            'data' => $data, 'nim_login' => $nim_login,
            'dosenPembimbing' => $dosenPembimbing, 'perAktif' => $perAktif
        ]);
    }

    public function AjukanPraKp(Request $request)
    {
        $idPeriode = DB::table('periode')->select('idPeriode')
            ->where('semester', $request->semester)
            ->where('tahun', $request->tahun)
            ->get();

        $data = new rpl;
        if ($request->file('dokPraKp')) {
            $file = $request->file('dokPraKp');
            $nim = $request->nim;
            $ext = $file->getClientOriginalExtension();
            $nama_file = $request->nim . "." . $file->getClientOriginalExtension();
            $path = 'dokumenPraKp';
            $file->move($path, $nama_file);
            $data->file = $nama_file;
        }
        $id = DB::table('registrasi')->insertGetId(
            [
                'nim' => $request->nim,
                'idPeriode' => $idPeriode[0]->idPeriode,
                'semester' => $request->semester,
                'tahun' => $request->tahun
            ]
        );

        $prakp = DB::table('praKp')->insert(
            [
                'judul' => $request->judul,
                'idReg' => $id,
                'tools' => $request->tools,
                'spesifikasi' => $request->spesifikasi,
                'lembaga' => $request->lembaga,
                'pimpinan' => $request->pimpinan,
                'noTelp' => $request->noTelp,
                'alamat' => $request->alamat,
                'fax' => $request->fax,
                'dokPraKp' => $data->file
            ]
        );
        return redirect('mahasiswa/PraKp')->with('success', 'Pengajuan pra kp berhasil ditambahkan!');
    }

    public function Kp()
    {
        $myString = auth()->user()->email;
        $nama = auth()->user()->name;
        $nim_login = DB::table('mahasiswa')->select('nim')
            ->where('nama', $nama)
            ->orWhere('email', $myString)
            ->get();
        $dosenPembimbing = DB::table('dosen')
            ->join('kp', 'kp.nik', '=', 'dosen.nik')
            ->select(DB::raw('dosen.namaDosen, dosen.nik'))
            ->distinct()
            ->get();
        $perAktif = DB::table('periode')
            ->select('tahun', 'semester', 'aktif')
            ->where('aktif', '1')
            ->get();
        $kp = DB::table('registrasi')
            ->join('kp', 'kp.idReg', '=', 'registrasi.idReg')
            ->join('periode', 'periode.idPeriode', '=', 'registrasi.idPeriode')
            ->select(DB::raw('registrasi.nim, kp.lembaga, kp.judul, kp.statusUjiKp, 
                kp.nik,registrasi.idPeriode,periode.aktif,registrasi.idReg'))
            ->orderBy('registrasi.idReg')
            ->get();
        return view('mahasiswa.Kp', [
            'kp' => $kp, 'nim_login' => $nim_login,
            'dosenPembimbing' => $dosenPembimbing, 'perAktif' => $perAktif
        ]);
    }

    public function AjukanKp(Request $request)
    {
        $idPeriode = DB::table('periode')->select('idPeriode')
            ->where('semester', $request->semester)
            ->where('tahun', $request->tahun)
            ->get();

        $data = new rpl;
        if ($request->file('dokKp')) {
            $file = $request->file('dokKp');
            $nim = $request->nim;
            $ext = $file->getClientOriginalExtension();
            $filename = $request->nim . "." . $file->getClientOriginalExtension();
            $path = 'dokumenPengajuanKp';
            $file->move($path, $filename);
            $data->file = $filename;
        }

        $idReg = DB::table('registrasi')->insertGetId([
            'nim' => $request->nim,
            'idPeriode' => $idPeriode[0]->idPeriode,
            'semester' => $request->semester,
            'tahun' => $request->tahun
        ]);

        DB::table('kp')->insert([
            'idReg' => $idReg,
            'judul' => $request->judul,
            'tools' => $request->tools,
            'spesifikasi' => $request->spesifikasi,
            'lembaga' => $request->lembaga,
            'pimpinan' => $request->pimpinan,
            'noTelp' => $request->noTelp,
            'alamat' => $request->alamat,
            'fax' => $request->fax,
            'dokKp' => $data->file
        ]);
        return redirect('/mahasiswa/Kp')->with(['success' => 'Pengajuan kerja praktik berhasil ditambahkan!']);
    }
}
