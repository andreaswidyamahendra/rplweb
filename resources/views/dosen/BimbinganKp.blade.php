@extends('layouts.layoutDosen')

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
    <h1 class="h3 mb-2 text-gray-800">Bimbingan KP</h1>
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
                    <th scope="col">Pengajuan Ujian</th>
                    <th scope="col">NIM</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Lembaga</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($nik as $nik_dosen)
                    @foreach($data as $bimbinganKp)
                    @if($nik_dosen->nik == $bimbinganKp->nik)
                    @if($bimbinganKp->pengajuanUjian == '0')
                        <tr>
                        <td>
                            <form method="post" action="/dosen/{idKp}/{nim}/setUjian">
                                {{csrf_field()}}
                                <a class="btn btn-success btn-sm" href="/dosen/{{$bimbinganKp->idKp}}/{{$bimbinganKp->nim}}/setUjian">
                                    Ajukan <span class="glyphicon glyphicon-ok"></a>
                                        </form>
                                        </td>
                                        <td>{{$bimbinganKp->nim}}</td>
                                        <td>{{$bimbinganKp->nama}}</td>
                                        <td>{{$bimbinganKp->judul}}</td>
                                        <td>{{$bimbinganKp->lembaga}}</td>
                        </tr>
                        @endif
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
    <h1 class="h3 mb-2 text-gray-800">Pengajuan Ujian</h1>
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
                    <th style="width: 10px">no</th>
                    <th width="20%">NIM</th>
                    <th width="40%">Nama</th>
                    <th width="40%">Status Pengajuan Ujian</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $no = 1;    
                @endphp
                <tbody>
                        @foreach($nik as $nik_dosen)
                            @foreach($dafPengajuan as $daftar)
                                @if($daftar->nik == $nik_dosen->nik)
                                    @if($daftar->pengajuanUjian == '1')
                                        <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$daftar->nim}}</td>
                                        <td>{{$daftar->nama}}</td>
                                        <td>    
                                            <span class="glyphicon glyphicon-ok-sign" style="color:green"> Diterima     
                                        </td>
                                        </tr>
                                    @endif
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