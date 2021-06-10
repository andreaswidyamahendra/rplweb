@extends('layouts.layoutMahasiswa')

@section('top')
<!-- Custom styles for this page -->
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection
@section('content')
<h1 class="h3 mb-2 text-gray-800">Pra KP</h1>
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
        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Ajukan Pra KP</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th width="30%">NIM</th>
                      <th width="40%">Judul</th>
                      <th width="40%">Lembaga</th>
                      <th width="30%">Status</th>
                    </tr>
                </thead>
                @php
                    $no = 1;    
                @endphp
                <tbody>
                @foreach($nim_login as $nim_log)
                @foreach($data as $data_prakp)
                  @if($data_prakp->aktif == '1')
                    @if($nim_log->nim == $data_prakp->nim)
                      <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{$data_prakp->nim}}</td>
                        <td>{{$data_prakp->judul}}</td>
                        <td>{{$data_prakp->lembaga}}</td>
                        <td>
                          @if($data_prakp->statusPraKp == '0')
                            <b>Belum Diverifikasi</b>
                          @endif
                          @if($data_prakp->statusPraKp == '1')
                            <span class="glyphicon glyphicon-ok-sign" style="color:green"> Diterima 
                          @endif
                          @if($data_prakp->statusPraKp == '2')
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
                <h5 class="modal-title" id="exampleModalLabel">Ajukan Pra KP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <form action="/mahasiswa/ajukanPraKp" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
      
            @foreach($nim_login as $nim_mhs)
        <div class="form-group">
          <label for="exampleInputEmail1">NIM :</label>
          <input name="nim" type="text" class="form-control" id="nim" required="required"
            value="{{$nim_mhs->nim}}" readonly>
        </div>
      @endforeach

      @foreach($perAktif as $aktif)
      <div class="form-row">
        <div class="form-group col-sm">
          <label for="exampleFormControlSelect1">Semester : </label>
          <input type="text" class="form-control" name="semester" style="width: 50%" required="required"
            value="{{$aktif->semester}}" readonly>
        </div>
        <div class="form-group col-sm">
          <label for="exampleFormControlInput1">Tahun : </label>
          <input type="number" class="form-control" name="tahun" style="width: 50%" required="required"
            value="{{$aktif->tahun}}" readonly>
        </div>
      </div>
      @endforeach

      <div class="form-group">
        <label for="exampleFormControlTextarea1">Judul Kerja Praktik :</label>
        <textarea class="form-control" id="judul" name="judul" rows="3" required="required"></textarea>
      </div>
      <div class="form-group">
        <label for="exampleFormControlTextarea1">Tools :</label>
        <textarea class="form-control" id="tools" name="tools" rows="3" required="required"></textarea>
      </div>
      <div class="form-group">
        <label for="exampleFormControlTextarea1">Spesifikasi Perangkat Lunak/ Pekerjaan KP :</label>
        <textarea class="form-control" id="spesifikasi" name="spesifikasi" rows="3" required="required"></textarea>
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Lembaga :</label>
        <input name="lembaga" type="text" class="form-control" id="lembaga" required="required">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Pimpinan Lembaga :</label>
        <input name="pimpinan" type="text" class="form-control" id="pimpinan" required="required">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">No. Telp Lembaga :</label>
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
        <label for="exampleFormControlFile1">Dokumen Pengajuan Pra KP :</label>
        <input type="file" class="form-control-file" id="dokPraKp" name="dokPraKp" required="required">
      </div>

      <button type="submit" class="btn btn-primary" name="Submit">Ajukan Pra KP</button>
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