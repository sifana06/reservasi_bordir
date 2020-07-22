@extends('dashboard.layouts.app')
@section('title', 'Data Users')

@section('content')
<div class="row">
  <!-- left column -->
  <div class="col-lg-12">
    <!-- general form elements -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <div class="box-title">
          <h4 style="margin-top: 0px; margin-bottom: 0px;">Edit Users</h4>
        </div>
      </div>
      @if ($errors->any())
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
        @endif
      <!-- /.box-header -->
      <!-- form start -->
      <form method="post" class="form-horizontal" action="{{ route('user.update',$user->id)}}" enctype="multipart/form-data" autocomplete="off">
        {{csrf_field()}}
        {{method_field('put')}}
        <div class="box-body">
          <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="name" placeholder="Nama akun" value="{{$user->name}}">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="email" placeholder="email@emai.com" value="{{$user->email}}">
            </div>
          </div>
          <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">Telepon</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="6283453234555" name="phone" value="{{$user->phone}}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">Role</label>
            <div class="col-sm-10">
              <select name="role" class="form-control">
                <option value="">Pilih role</option>
                <option value="admin" {{$user->role == 'admin' ? 'selected':''}}>Admin</option>
                <option value="pemilik" {{$user->role == 'pemilik' ? 'selected':''}}>Pemilik</option>
                <option value="pelanggan"  {{$user->role == 'pelanggan' ? 'selected':''}}>Pelanggan</option>
              </select>
            </div>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <button type="reset" class="btn btn-default">Batal</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
        <!-- /.box-footer -->
      </form>
    </div>
  </div>
  <!--/.col (left) -->

@endsection

@push('header')
@endpush

@push('footer')
@endpush
