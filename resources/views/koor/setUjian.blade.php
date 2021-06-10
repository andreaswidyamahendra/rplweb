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
                    <th width="15%">Nim</th>
                    <th width="15%">Nama</th>
                    <th width="15%">Judul</th>
                    <th width="15%">Dosen Pembimbing</th>
                    <th width="15%">Dosen Penguji</th>
                    <th width="5%">Tanggal</th>
                    <th width="15%">Jam</th>
                    <th width="15%">Ruangan</th>
                    <th width="15%">Aksi</th>
                    </tr>
                </thead>
                    <tbody>
                            @foreach($data as $dataUjian)
                            @if($dataUjian->nik == null)
                            <form method="post" id="masuk" enctype="multipart/form-data" action="/koor/setUjian">
                                {{csrf_field()}}
                                <fieldset disabled>
                                    <div class="form-row">
                                        <div class="col-7">
                                            <?php
                                            $idUjian = $dataUjian->idUjian;
                                            ?>
                                            <input type="hidden" name="idUjian" value="{{$idUjian}}">
                                            <td><input type="text" name="nim" value="{{$dataUjian->nim}}" class="form-control" readonly></td>
                                            <td><input type="text" name="nama" value="{{$dataUjian->nama}}" class="form-control" disabled></td>
                                            <td><input type="text" name="judul" value="{{$dataUjian->judul}}" class="form-control" disabled></td>
                                            <td><input type="text" name="namaDosen" value="{{$dataUjian->namaDosen}}" class="form-control" disabled></td>
                                        </div>
                                    </div>
                                </fieldset>
                                <td>
                                    <select class="custom-select-lg" name="nik" required>
                                        @foreach($dosenPenguji as $dosen)
                                        <option value="{{$dosen->nik}}">{{$dosen->namaDosen}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="date" class="form-control" name="tglUjian" required="required">
                                </td>
                                <td>
                                    <input type="time" class="form-control" name="jamUjian" required="required">
                                </td>
                                <td>
                                    <select class="custom-select-lg" name="ruang" id="ruangan" required>
                                        @foreach($dataRuangan as $ruang)
                                        @php $idRuang = $ruang->idRuang @endphp
                                        <option value="{{$idRuang}}">{{$ruang->namaRuang}}</option>
                                        @endforeach
                                    </select>

                                </td>
                                <td>
                                    <button type="submit" href="/koor/setSurat" name="input" class="btn btn-primary btn-sm" value="{{$idUjian}}">
                                        <span>Submit</span>
                                </td>
                        </tr>
                        </form>
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