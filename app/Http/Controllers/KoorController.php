<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\mhs;
use DB;
use Session;
use Symfony\Component\Console\Input\Input;
use App\Post;
use Carbon;

class KoorController extends Controller
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
        return view('koor.BimbinganKp', [
            'nik' => $nik, 'namaDosen' => $namaDosen,
            'data' => $data, 'dafPengajuan' => $dafPengajuan, 'ujian' => $ujian
        ]);
    }

    public function ajuinUjian($idKp, $nim){
        $id = DB::table('ujian')->insertGetId([
            'idKp' => $idKp,
            'nim' => $nim
        ]);
        $pengajuan = DB::table('kp')
            ->where('idKp', $idKp)
            ->update(['pengajuanUjian' => 1]);  
        return redirect('/koor/BimbinganKp');
    }

    public function setUjian(Request $request)
    {
        $idUjian = $request->input;
        $ruang = $request->ruang;
        $nik = $request->nik;
        $tgl = $request->tglUjian;
        $jam = $request->jamUjian;

        $ujian = DB::table('ujian')
            ->where('idUjian', $idUjian)
            ->update(
                [
                    'idRuang' => $ruang,
                    'nik' => $nik,
                    'tglUjian' => $tgl,
                    'jamUjian' => $jam
                ]
            );
        return redirect('/koor/setUjian')->with(['success' => 'Data Ujian Berhasil Disimpan!']);
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
        return view('koor.UjianKp', ['nik' => $nik, 'namaDosen' => $namaDosen, 'dafUjian' => $dafUjian, 'dafPenguji' => $dafPenguji]);
    }

    public function RegisKp()
    {
        $myString = auth()->user()->email;
        $namaDosen = DB::table('dosen')->select('namaDosen')
            ->where('email', $myString)
            ->get();
        $nik = DB::table('dosen')->select('nik')
            ->where('email', $myString)
            ->get();

        $nikDosbing = DB::table('dosen')->select('nik', 'namaDosen')->get();

        $data = DB::table('registrasi')
            ->join('mahasiswa', 'mahasiswa.nim', '=', 'registrasi.nim')
            ->join('kp', 'kp.idReg', '=', 'registrasi.idReg')
            ->join('periode', 'periode.idPeriode', '=', 'registrasi.idPeriode')
            ->select(
                'registrasi.idReg',
                'registrasi.nim',
                'mahasiswa.nama',
                'kp.idKp',
                'kp.judul',
                'kp.lembaga',
                'periode.aktif'
            )
            ->where([
                ['kp.statusUjiKp', '=', '0'],
                ['periode.aktif', '=', '1']
            ])
            ->get();

        $perAktif = DB::table('periode')
            ->select('tahun', 'semester')
            ->where('aktif', '1')
            ->get();

        $dataStatus = DB::table('registrasi')
            ->join('mahasiswa', 'mahasiswa.nim', '=', 'registrasi.nim')
            ->join('kp', 'kp.idReg', '=', 'registrasi.idReg')
            ->join('periode', 'periode.idPeriode', '=', 'registrasi.idPeriode')
            ->select('registrasi.nim', 'mahasiswa.nama', 'kp.judul', 'kp.statusUjiKp', 'periode.aktif')
            ->where([
                ['kp.statusUjiKp', '=', '1'],
                ['periode.aktif', '=', '1']
            ])
            ->orWhere([
                ['kp.statusUjiKp', '=', '2'],
                ['periode.aktif', '=', '1']
            ])
            ->get();

        return view('koor.RegisKp', ['nik' => $nik, 'namaDosen' => $namaDosen, 'nikDosbing' => $nikDosbing, 'data' => $data, 'dataStatus' => $dataStatus]);
    }

    public function setKp(Request $request)
    {
        $terima = $request->terima;
        $tolak = $request->tolak;
        if ($terima) {
            if (isset($request->dosenUji)) {
                $status = DB::table('kp')
                    ->where('idReg', $terima)
                    ->update([
                        'statusUjiKp' => 1,
                        'nik' => $request->dosenUji
                    ]);
                return redirect('/koor/RegisKp')->with('success', 'Status KP Berhasil Diubah!');
            }
            return redirect('/koor/RegisKp')->with('warning', 'Dosen Pembimbing Tidak Boleh Kosong');
        } else if ($tolak) {
            $status = DB::table('kp')
                ->where('idReg', $tolak)
                ->update([
                    'statusUjiKp' => 2
                ]);
        }

        return redirect('/koor/RegisKp')->with('success', 'Status Verifikasi KP Berhasil Diubah!');
    }

    public function openkp($nim)
    {
        $path = public_path('dokumenPengajuanKp/' . $nim . '.pdf');
        header("Content-type: application/pdf");
        header("Content-Length: " . filesize($path));
        readfile($path);
    }

    public function RegisPraKp()
    {
        $myString = auth()->user()->email;
        $namaDosen = DB::table('dosen')->select('namaDosen')
            ->where('email', $myString)
            ->get();
        $nik = DB::table('dosen')->select('nik')
            ->where('email', $myString)
            ->get();

            $data = DB::table('registrasi')
            ->join('mahasiswa', 'mahasiswa.nim', '=', 'registrasi.nim')
            ->join('prakp', 'prakp.idReg', '=', 'registrasi.idReg')
            ->join('periode', 'periode.idPeriode', '=', 'registrasi.idPeriode')
            ->select(
                'registrasi.idReg',
                'registrasi.nim',
                'registrasi.idPeriode',
                'mahasiswa.nama',
                'prakp.idPraKp',
                'prakp.judul',
                'prakp.lembaga',
                'prakp.dokPraKp',
                'periode.aktif'
            )
            ->where([
                ['prakp.statusPraKp', '=', '0'],
                ['periode.aktif', '=', '1']
            ])
            ->get();

        $dataStatus = DB::table('registrasi')
            ->join('mahasiswa', 'mahasiswa.nim', '=', 'registrasi.nim')
            ->join('prakp', 'prakp.idReg', '=', 'registrasi.idReg')
            ->join('periode', 'periode.idPeriode', '=', 'registrasi.idPeriode')
            ->select(
                'registrasi.nim',
                'mahasiswa.nama',
                'prakp.judul',
                'prakp.statusPraKp',
                'prakp.dokPraKp',
                'periode.aktif'
            )
            ->where([
                ['prakp.statusPraKp', '=', '1'],
                ['periode.aktif', '=', '1']
            ])
            ->orWhere([
                ['prakp.statusPraKp', '=', '2'],
                ['periode.aktif', '=', '1']
            ])
            ->get();

        return view('koor.RegisPraKp', ['nik' => $nik, 'namaDosen' => $namaDosen, 'data' => $data, 'dataStatus' => $dataStatus]);
    }

    public function setPraKp(Request $request)
    {
        $terima = $request->terima;
        $tolak = $request->tolak;

        if ($terima) {
            $status = DB::table('prakp')
                ->where('idReg', $terima)
                ->update([
                    'statusPraKp' => 1
                ]);
        } else if ($tolak) {
            $status = DB::table('prakp')
                ->where('idReg', $tolak)
                ->update([
                    'statusPraKp' => 2
                ]);
        }
        return redirect('/koor/RegisPraKp')->with('success', 'Status Verifikasi Pra KP Berhasil Diubah');
    }

    public function openprakp($nim)
    {
        $path = public_path('dokumenPraKp/' . $nim . '.pdf');
        header("Content-type: application/pdf");
        header("Content-Length: " . filesize($path));
        readfile($path);
    }

    public function SuratKet()
    {
        $myString = auth()->user()->email;
        $namaDosen = DB::table('dosen')->select('namaDosen')
            ->where('email', $myString)
            ->get();
        $nik = DB::table('dosen')->select('nik')
            ->where('email', $myString)
            ->get();

        $surat = DB::table('registrasi')
            ->join('mahasiswa', 'mahasiswa.nim', '=', 'registrasi.nim')
            ->join('surat', 'surat.idReg', '=', 'registrasi.idReg')
            ->join('periode', 'periode.idPeriode', '=', 'registrasi.idPeriode')
            ->select(
                'registrasi.idReg',
                'registrasi.nim',
                'registrasi.idPeriode',
                'mahasiswa.nama',
                'surat.idSurat',
                'surat.lembaga',
                'surat.dokSurat',
                'periode.aktif'
            )
            ->where([
                ['surat.statusSurat', '=', '0'],
                ['periode.aktif', '=', '1']
            ])
            ->get();

        $dataStatus = DB::table('registrasi')
            ->join('mahasiswa', 'mahasiswa.nim', '=', 'registrasi.nim')
            ->join('surat', 'surat.idReg', '=', 'registrasi.idReg')
            ->join('periode', 'periode.idPeriode', '=', 'registrasi.idPeriode')
            ->select(
                'registrasi.nim',
                'mahasiswa.nama',
                'surat.lembaga',
                'surat.dokSurat',
                'surat.statusSurat',
                'periode.aktif'
            )
            ->where([
                ['surat.statusSurat', '=', '1'],
                ['periode.aktif', '=', '1']
            ])
            ->orWhere([
                ['surat.statusSurat', '=', '2'],
                ['periode.aktif', '=', '1']
            ])
            ->get();

        return view('koor.SuratKet', [
            'nik' => $nik, 'namaDosen' => $namaDosen,
            'surat' => $surat, 'dataStatus' => $dataStatus
        ]);
    }

    public function setSurat(Request $request)
    {
        $terima = $request->terima;
        $tolak = $request->tolak;

        if ($terima) {
            $status = DB::table('surat')
                ->where('idReg', $terima)
                ->update([
                    'statusSurat' => 1
                ]);
        } else if ($tolak) {
            $status = DB::table('surat')
                ->where('idReg', $tolak)
                ->update([
                    'statusSurat' => 2
                ]);
        }
        return redirect('/koor/SuratKet')->with('success', 'Status Verifikasi Pengajuan Surat Berhasil Diubah!');
    }

    public function opensurat($nim)
    {
        $path = public_path('suratKeterangan/' . $nim . '.pdf');
        header("Content-type: application/pdf");
        header("Content-Length: " . filesize($path));
        readfile($path);
    }

    public function setUjianK()
    {
        $myString = auth()->user()->email;
        $namaDosen = DB::table('dosen')->select('namaDosen')
            ->where('email', $myString)
            ->get();
        $nik = DB::table('dosen')->select('nik')
            ->where('email', $myString)
            ->get();
        $dosenPenguji = DB::table('dosen')
            ->select(DB::raw('nik,namaDosen'))
            ->get()->toArray();
        $dataRuangan = DB::table('ruang')
            ->select(DB::raw('idRuang,namaRuang'))
            ->get()->toArray();
        $data = DB::table('ujian')
            ->join('kp', 'ujian.idKp', '=', 'kp.idKp')
            ->join('registrasi', 'kp.idReg', '=', 'registrasi.idReg')
            ->join('mahasiswa', 'registrasi.nim', '=', 'mahasiswa.nim')
            ->join('dosen', 'kp.nik', '=', 'dosen.nik')
            ->select(DB::raw('ujian.idUjian, mahasiswa.nim, mahasiswa.nama, kp.judul, dosen.namaDosen, ujian.nik'))
            ->get();
        return view('koor.setUjian', ['nik' => $nik, 'namaDosen' => $namaDosen, 'data' => $data, 'dosenPenguji' => $dosenPenguji, 'dataRuangan' => $dataRuangan]);
    }

    public function BatasKp()
    {
        $myString = auth()->user()->email;
        $namaDosen = DB::table('dosen')->select('namaDosen')
            ->where('email', $myString)
            ->get();
        $nik = DB::table('dosen')->select('nik')
            ->where('email', $myString)
            ->get();
        $aktif = DB::table('periode')
            ->select('semester', 'tahun', 'mulaiKp', 'akhirKp', 'aktif')
            ->get();
        return view('koor.BatasKp', ['nik' => $nik, 'namaDosen' => $namaDosen, 'aktif' => $aktif]);
    }

    public function setBatas(Request $request)
    {
        $affected = DB::table('periode')
            ->where('aktif', 1)
            ->update(['aktif' => 0]);
        $tanggalSekarang = Carbon\Carbon::now();
        DB::table('periode')->insert([
            'semester' => $request->semester,
            'tahun' => $request->tahun,
            'mulaiKp' => $tanggalSekarang,
            'akhirKp' => $request->akhirKp,
            'aktif' => $request->aktif
        ]);
        return redirect('/koor/BatasKp')->with(['success' => 'Batas Pelaksanaan Kerja Praktik Berhasil Disimpan!']);
    }
}
