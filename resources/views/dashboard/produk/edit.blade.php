@extends('dashboard.layouts.app')
@section('title', 'Data Produk')

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
        <div class="box box-info">
            <div class="box-header with-border" style="margin-left:0px;">
                <h4 style="margin-top:0px; margin-bottom:0px;"><a href="{{route('toko.index')}}"><span class="fa fa-arrow-left"></span></a> Edit Produk</h4>
            </div>
            <form method="post" action="{{route('product.update',$produk->id)}}" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
                <div class="box-body">
                    <div class="row" style="margin-top:0px;">
                        <div class="col-sm-3" style="margin-top: 0px;">
                            <div class="form-group" style="margin-top:0px;">
                                <label style="margin-bottom:10px;">Foto Toko</label>
                                <div id="image-preview" style="background-image: url({{ '/uploads/' . $produk->foto }});background-size: cover;background-position: center center;">
                                    <label for="image-upload" id="image-label" style="color:#f0f0f0;">Choose File</label>
                                    <input type="file" name="foto" id="image-upload" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top:0px;">
                        <label>Nama Produk</label>
                        <input type="text" class="form-control" name="nama" placeholder="Bordir tepi logo" value="{{$produk->nama}}">
                    </div>
                    <div class="form-group" style="margin-top:0px;">
                        <label>Harga</label>
                        <input type="text" class="form-control" name="harga" placeholder="29500" value="{{$produk->harga}}">
                    </div>
                    <div class="form-group" style="margin-top:0px;">
                        <label>Toko</label>
                        <select name="store_id" class="form-control">
                            <option value="">-- Pilih Toko --</option>
                            @foreach($toko as $t)
                            <option value="{{$t->id}}" {{ $produk->store_id == $t->id ? 'selected' : ''}}>{{$t->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin-top:0px;">
                        <label>Jenis Bordir</label>
                        <select name="jenis_bordir" class="form-control">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="logo" {{$produk->jenis_bordir == 'logo' ? 'selected' : ''}}>Bordir Logo</option>
                            <option value="kaos" {{$produk->jenis_bordir == 'kaos' ? 'selected' : ''}}>Bordir Kaos</option>
                        </select>
                    </div>
                    <div class="form-group" style="margin-top:0px;">
                        <label>Deskripsi</label>
                        <textarea class="form-control" rows="3" name="deskripsi" placeholder="Deskripsi Produk">{{$produk->deskripsi}}</textarea>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="reset" class="btn btn-primary btn-sm bg-navy">Reset</button>
                    <button type="submit" class="btn btn-success btn-sm bg-green">Simpan</button>
                </div>
            </form>
          </div>
        </div>
    </div>
  <!--/.col (right) -->
@endsection

@push('header')
<link rel="stylesheet" href="/assets/material/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style>
    /** Image preview */
#image-preview {
    width: 100%;
    height: 160px;
    position: relative;
    overflow: hidden;
    background-color: #e6ecf3;
    color: #4a5152;
    border: 2px dashed #ccc;
    border-radius: 2px;
}
#image-preview input {
    line-height: 150px;
    font-size: 18px;
    position: absolute;
    opacity: 0;
    z-index: 10;
}
#image-preview label {
    position: absolute;
    z-index: 5;
    opacity: 0.8;
    cursor: pointer;
    background-color: #bdc3c7;
    width: 110px;
    height: 40px;
    font-size: 12px;
    line-height: 3.4em;
    text-transform: uppercase;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    text-align: center;
}
</style>
@endpush

@push('footer')
<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="/js/jquery.uploadPreview.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $.uploadPreview({
        input_field: "#image-upload",
        preview_box: "#image-preview",
        label_field: "#image-label"
    });
});
</script>
<script src="/assets/material/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets/material/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="/resource/js/image-prerview.js"></script>
@endpush
