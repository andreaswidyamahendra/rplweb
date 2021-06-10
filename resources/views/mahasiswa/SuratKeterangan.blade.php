@extends('layouts.layoutMahasiswa')

@section('top')
<!-- Custom styles for this page -->
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('content')
<h1 class="h3 mb-2 text-gray-800">Surat Keterangan</h1>
<br>

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
        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Ajukan Surat Keterangan</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th width="30%">NIM</th>
                      <th width="40%">Lembaga</th>
                      <th width="30%">Status</th>
                    </tr>
                </thead>
                @php
                    $no = 1;    
                @endphp
                <tbody>
                @foreach($nim_login as $nim_log)
                @foreach($data as $data_surat)
                  @if($data_surat->aktif == '1')
                    @if($nim_log->nim == $data_surat->nim)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{$data_surat->nim}}</td>
                        <td>{{$data_surat->lembaga}}</td>
                        <td>
                          @if($data_surat->statusSurat == '0')
                            <b>Belum Diverifikasi</b>
                          @endif
                          @if($data_surat->statusSurat == '1')
                            <span class="glyphicon glyphicon-ok-sign" style="color:green"> Diterima 
                          @endif

                          @if($data_surat->statusSurat == '2')
                            <span class="glyphicon glyphicon-remove-sign" style="color:red"> Ditolak 
                          @endif
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
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ajukan Surat Keterangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="/mahasiswa/ajukanSuratKet" method="POST" enctype="multipart/form-data">
      {{csrf_field()}}

      @foreach($nim_login as $nim_mhs)
        <div class="form-group">
          <label for="exampleInputEmail1">NIM :</label> 
          <input name="nim" type="text" class="form-control" id="nim" required="required" style="width: 100%"
            value="{{$nim_mhs->nim}}" readonly>
        </div>
      @endforeach

      @foreach($perAktif as $aktif)
      <div class="form-row">
        <div class="form-group col-sm">
          <label for="exampleFormControlSelect1">Semester : </label> 
          <input type="text" class="form-control" name="semester" style="width: 100%" required="required"
            value="{{$aktif->semester}}" readonly>
        </div>
        <div class="form-group col-sm">
          <label for="exampleFormControlInput1">Tahun : </label>
          <input type="number" class="form-control" name="tahun" style="width: 100%" required="required"
            value="{{$aktif->tahun}}" readonly>
        </div>
      </div>
      @endforeach

      <div class="form-group">
        <label for="exampleInputEmail1">Lembaga :</label>
        <input name="lembaga" type="text" class="form-control" id="lembaga" required="required">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Pimpinan :</label>
        <input name="pimpinan" type="text" class="form-control" id="pimpinan" required="required">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">No. Telp :</label>
        <input name="noTelp" type="text" class="form-control" id="noTelp" required="required">
      </div>
      <div class="form-group">
        <label for="exampleFormControlTextarea1">Alamat :</label>
        <textarea class="form-control" id="alamat" name="alamat" rows="3" required="required"></textarea>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Fax :</label>
        <input name="fax" type="text" class="form-control" id="fax" aria-describedby="emailHelp" required="required">
      </div>
      <div class="form-group">
        <label for="exampleFormControlFile1">Dokumen Pengajuan Surat Keterangan:</label>
        <input type="file" class="form-control-file" id="dokSurat" name="dokSurat" required="required">
      </div>

      <button type="submit" class="btn btn-primary" name="Submit">Ajukan Surat Keterangan</button>
    </form>
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