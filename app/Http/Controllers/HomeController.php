<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Symfony\Component\Console\Input\Input;
use App\Post;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $myString = auth()->user()->email;
        $nim = DB::table('mahasiswa')->select('nim')
            ->where('email', $myString)
            ->get();
        $nik = DB::table('dosen')->select('nik')
            ->where('email', $myString)
            ->get();
        $users = DB::table('dosen')->where('email', $myString)->value('koor');
        $emailDos = DB::table('dosen')->where('email', $myString)->value('email');
        $email = DB::table('mahasiswa')->where('email', $myString)->value('email');
        $emailD = DB::table('users')->where('email', $myString)->value('email');

        if ($contains = Str::contains($myString, 'si.ukdw.ac.id') && $email != "") {
            return view('home', ['nim' => $nim]);
        } else if ($emailDos == "") {
            return view('logout');
        } else if ($contains = Str::contains($myString, 'students.ukdw.ac.id') && $users == "0") {
            return view('homeDosen', ['nik' => $nik]); 
        } else if ($contains = Str::contains($myString, 'students.ukdw.ac.id') && $users == "1") {
            return view('homeKoor', ['nik' => $nik]);
        }
    }

    public function index_dosen()
    {
        $myString = auth()->user()->email;
        $nik = DB::table('dosen')->select('nik')
            ->where('email', $myString)
            ->get();
        return view('homeDosen', ['nik' => $nik]);
    }

    public function index_koor()
    {
        $myString = auth()->user()->email;
        $nik = DB::table('dosen')->select('nik')
            ->where('email', $myString)
            ->get();
        return view('homeKoor', ['nik' => $nik]);
    }

    public function log()
    {
        return view('login');
    }
}
