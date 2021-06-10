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
    <h1 class="h3 mb-2 text-gray-800">Daftar Registrasi KP</h1>
                    <h7><b>Nama Koordinator KP : </b></h7>
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
                    <th width="10%">Nim</th>
                    <th width="10%">Nama</th>
                    <th width="10%">Judul</th>
                    <th width="10%">Lembaga</th>
                    <th width="10%">Dokumen KP</th>
                    <th width="10%">Status Verifikasi</th>
                    <th width="10%">Dosen Pembimbing</th>
                    </tr>
                </thead>
                @foreach($data as $dataKp)
                        <form method="post" enctype="multipart/form-data" action="{{ URL::to('/') }}/koor/setKp">
                            {{csrf_field()}}
                            <input type="hidden" name="idReg" value="{{ $dataKp->idReg }}">
                            <tr>
                                <td>
                                    <select class="custom-select" name="dosenUji">
                                        <option value="">Nama Dosen</option>
                                        @foreach ($nikDosbing as $nikDos)
                                        <option value="{{$nikDos->nik}}">{{$nikDos->namaDosen}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>{{$dataKp->nim}}</td>
                                <td>{{$dataKp->nama}}</td>
                                <td>{{$dataKp->judul}}</td>
                                <td>{{$dataKp->lembaga}}</td>
                                <td>
                                    <a href="/koor/openkp/{{$dataKp->nim}}" target="_blank" class="btn btn-primary">
                                        View File <span class="glyphicon glyphicon-eye-open">
                                    </a>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input type="hidden" name="idReg" value="{{$dataKp->idReg}}">
                                        <button type="submit" href="/koor/setKp" name="terima" class="btn btn-success btn-sm" value="{{$dataKp->idReg}}">Terima</button>
                                        <br><br>
                                        <button type="submit" href="/koor/setKp" name="tolak" class="btn btn-danger btn-sm" value="{{$dataKp->idReg}}">Tolak</button>
                                    </div>
                                </td>
                            </tr>
                        </form>
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
    <h1 class="h3 mb-2 text-gray-800">Daftar Verifikasi Pengajuan KP</h1>
                    <h7><b>Nama Koordinator KP : </b></h7>
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
                    <th width="10%">No</th>
                    <th width="10%">Nim</th>
                    <th width="10%">Nama</th>
                    <th width="10%">Judul</th>
                    <th width="10%">Dokumen KP</th>
                    <th width="10%">Status Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $no = 1;
                    @endphp
                    <tbody>
                        @foreach($dataStatus as $dataVer)
                        @if($dataVer->statusUjiKp == 1)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$dataVer->nim}}</td>
                            <td>{{$dataVer->nama}}</td>
                            <td>{{$dataVer->judul}}</td>
                            <td>
                                <a href="/koor/openkp/{{$dataVer->nim}}" target="_blank" class="btn btn-primary">
                                    View File <span class="glyphicon glyphicon-eye-open">
                                </a>
                            </td>
                            <td>
                                <span class="glyphicon glyphicon-ok-sign" style="color:green"> Diterima
                            </td>
                        </tr>
                        @elseif($dataVer->statusUjiKp == 2)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$dataVer->nim}}</td>
                            <td>{{$dataVer->nama}}</td>
                            <td>{{$dataVer->judul}}</td>
                            <td>
                                <a href="/koor/openkp/{{$dataVer->nim}}" target="_blank" class="btn btn-primary">
                                    View File <span class="glyphicon glyphicon-eye-open">
                                </a>
                            </td>
                            <td>
                                <span class="glyphicon glyphicon-remove-sign" style="color:red"> Ditolak
                            </td>
                        </tr>
                        @endif
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