@extends('dashboard.layouts.app')
@section('title', 'Data Rekening')

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>    
        <strong>{{ $message }}</strong>
        </div>
        @endif
        @if ($message = Session::get('message'))
        <div class="alert alert-warning alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>    
        <strong>{{ $message }}</strong>
        </div>
        @endif
        @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>    
        <strong>{{ $message }}</strong>
        </div>
        @endif
        <!-- general form elements -->
        <div class="box box-primary">
        <div class="box-header with-border">
            <div class="box-title">
            <h4 style="margin-top: 0px; margin-bottom: 0px;"><a href="{{route('rekening.index')}}"><span class="fa fa-arrow-left"></span></a> Tambah Nomor Rekaning Baru</h4>
            </div>
        </div>
        <!-- /.box-header -->
        @if($errors->any())
        <div class="alert alert-warning alert-dismissble">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
                    
                @endforeach
            </ul>

        </div>
        @endif
        <!-- form start -->
        <form method="post" action="{{ route('rekening.store')}}" enctype="multipart/form-data" autocomplete="off">
            <div class="box-body">
            @csrf
            <div class="form-group">
                <label>Nama Bank</label>
                <input type="text" class="form-control" name="nama_bank" placeholder="Bank BRI">
            </div>
            <div class="form-group">
                <label >No Rekening</label>
                <input type="text" class="form-control" name="no_rekening" placeholder="5556238261">
            </div>
            <div class="form-group">
                <label>Nama Pemilik Rekening</label>
                <input type="text" class="form-control" placeholder="Ahmad Rojali" name="nama_pemilik">
            </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            <button type="reset" class="btn btn-warning">Batal</button>
            <button type="submit" class="btn btn-success">Simpan</button>
            </div>
            <!-- /.box-footer -->
        </form>
        </div>
    </div>
  <!--/.col (right) -->
  <div class="modal fade" id="konfirmasi_hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
     <div class="modal-content">
      <div class="modal-body text-center">
       <b>Anda yakin ingin menghapus Permanen data ini ?</b>
       <br><br>
       <a class="btn btn-danger btn-ok"> Hapus</a><button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
     </div>
   </div>
 </div>
</div>
@endsection

@push('header')
<link rel="stylesheet" href="/assets/material/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endpush

@push('footer')
<script src="/assets/material/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/material/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
@endpush
