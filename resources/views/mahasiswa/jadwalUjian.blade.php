@extends('layouts.layoutMahasiswa')

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
        @foreach($nama as $nama_mhs)
          <h7>Nama : </h7>
          {{$nama_mhs->nama}}<br>
        @endforeach
        @foreach($nim as $nim_mhs)
          <h7>NIM : </h7>
          {{$nim_mhs->nim}}<br>
        @endforeach
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
                    <th width="15%">Judul</th>
                    <th width="15%">Dosen Pembimbing</th>
                    <th width="18%">Dosen Penguji</th>
                    </tr>
                </thead>
                @php
            $no = 1;
          @endphp
          <tbody>
            @foreach($ujian as $u)
            <tr>
              <td>{{$no++}}</td>
              <td>{{$u->tglUjian}}</td>
              <td>{{$u->jamUjian}}</td>
              <td>{{$u->namaRuang}}</td>
              @foreach($dosbing as $d)
                <td>{{$d->judul}}</td>
                <td>{{$d->namaDosen}}</td>
              @endforeach
              <td>{{$u->namaDosen}}</td>
            </tr>
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