@extends('layouts.layoutKoor')

@section('top')
<!-- Custom styles for this page -->
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('content')

@if(session('sukses'))
<div class="alert alert-success" role="alert">
    {{session('sukses')}}
</div>
@elseif(session('gagal'))
<div class="alert alert-danger" role="alert">
    {{session('gagal')}}
</div>
@endif


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
    <h1 class="h3 mb-2 text-gray-800">Ujian Kerja Praktik</h1>
                    <h7><b>Nama Dosen : </b></h7>
                    {{auth()->user()->name}}<br>
                    <h7><b>NIK : </b></h7>
                    @foreach($nik as $nikDosenLogin)
                    {{$nikDosenLogin->nik}}
                    @endforeach<br><br>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th width="2%">No</th>
                    <th width="10%">Tanggal</th>
                    <th width="10%">Jam</th>
                    <th width="10%">Ruangan</th>
                    <th width="10%">Nim</th>
                    <th width="10%">Nama</th>
                    <th width="15%">Judul</th>
                    <th width="15%">Lembaga</th>
                    <th width="18%">Dosen Penguji</th>
                    </tr>
                </thead>
                @php
                    $no = 1;    
                @endphp
                    <tbody>
                            @foreach($nik as $nikDosbing)
                                @foreach($dafUjian as $daftar)
                                    @if($nikDosbing->nik == $daftar->nik)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$daftar->tglUjian}}</td>
                                            <td>{{$daftar->jamUjian}}</td>
                                            <td>{{$daftar->namaRuang}}</td>
                                            <td>{{$daftar->nim}}</td>
                                            <td>{{$daftar->nama}}</td>
                                            <td>{{$daftar->judul}}</td>
                                            <td>{{$daftar->lembaga}}</td>
                                            <td>{{$daftar->namaDosen}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
    <h1 class="h3 mb-2 text-gray-800">Daftar Ujian Dosen Penguji</h1>
                    <h7><b>Nama Dosen : </b></h7>
                    {{auth()->user()->name}}<br>
                    <h7><b>NIK : </b></h7>
                    @foreach($nik as $nikDosenLogin)
                        {{$nikDosenLogin->nik}}
                    @endforeach<br><br>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                    <th width="2%">No</th>
                    <th width="10%">Tanggal</th>
                    <th width="10%">Jam</th>
                    <th width="10%">Ruangan</th>
                    <th width="10%">Nim</th>
                    <th width="10%">Nama</th>
                    <th width="15%">Judul</th>
                    <th width="15%">Lembaga</th>
                    <th width="17%">Dosen Pembimbing</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $no = 1;    
                @endphp
                        <tbody>
                            @foreach($nik as $nikPenguji)
                                @foreach($dafPenguji as $daftarPenguji)
                                    @if($nikPenguji->nik == $daftarPenguji->nik)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$daftarPenguji->tglUjian}}</td>
                                            <td>{{$daftarPenguji->jamUjian}}</td>
                                            <td>{{$daftarPenguji->namaRuang}}</td>
                                            <td>{{$daftarPenguji->nim}}</td>
                                            <td>{{$daftarPenguji->nama}}</td>
                                            <td>{{$daftarPenguji->judul}}</td>
                                            <td>{{$daftarPenguji->lembaga}}</td>
                                            <td>{{$daftarPenguji->namaDosen}}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('bottom')
<!-- Page level plugins -->
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#tanggal').datepicker();
        $('#dataTable').DataTable();
    });
</script>
@endsection