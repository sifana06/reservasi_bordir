@extends('dashboard.layouts.app')
@section('title', 'Data Toko')

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
        <div class="box box-info">
            <div class="box-header with-border" style="margin-left:0px;">
                <h4 style="margin-top:0px; margin-bottom:0px;"><a href="{{route('toko.index')}}"><span class="fa fa-arrow-left"></span></a> Edit Toko</h4>
            </div>
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
            <form method="post" action="{{route('toko.update', $store->id)}}">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
                <div class="box-body">
                    <div class="form-group" style="margin-top:0px;">
                        <label>Nama Toko</label>
                        <input type="text" class="form-control" name="nama" placeholder="Gunting Emas" value="{{$store->nama}}">
                    </div>
                    <div class="form-group" style="margin-top:0px;">
                        <label>No. Telepon</label>
                        <input type="text" class="form-control" name="phone" placeholder="082328321344" value="{{$store->phone}}">
                    </div>
                    <div class="row" style="margin-top:0px;">
                        <div class="col-md-4" style="margin-top:0px;">
                            <div class="form-group" style="margin-top:0px;">
                                <label>Kabupaten</label>
                                <select name="kabupaten" class="form-control">
                                    <option value="">--- Kabupaten  ---</option>
                                    @foreach ($kabupaten as $value)
                                        <option value="{{ $value->id }}" {{$store->kabupaten == $value->id ? 'selected':''}}>{{ $value->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    <div class="col-md-4" style="margin-top:0px;">
                        <div class="form-group" style="margin-top:0px;">
                            <label>Kecamatan</label>
                            <!-- <input type="text" class="form-control" name="kecamatan" placeholder="Kecamatan Tarub"> -->
                            <select name="kecamatan" class="form-control">
                                <option>-- Kecamatan --</option>
                                @foreach ($kecamatan as $kec)
                                <option value="{{$kec->id}}" {{$store->kecamatan == $kec->id ? 'selected':''}}>{{$kec->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4" style="margin-top:0px;">
                        <div class="form-group" style="margin-top:0px;">
                            <label>Desa</label>
                            <select name="desa" class="form-control">
                                <option>-- Desa --</option>
                                @foreach ($desa as $des)
                                <option value="{{$des->id}}" {{$store->desa == $des->id ? 'selected':''}}>{{$kec->nama}}</option>
                                @endforeach
                            </select>
                       </div>
                    </div>
                    </div>
                    <div class="form-group" style="margin-top:0px;">
                        <label>Alamat</label>
                        <textarea class="form-control" rows="3" name="alamat" placeholder="Jalan Mawar Merah No 69">{{$store->alamat}}</textarea>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success btn-sm bg-green">Simpan</button>
                </div>
            </form>
          </div>
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

<!-- Input Kecamatan -->
<script type="text/javascript">
    $(document).ready(function() {
        $('select[name="kabupaten"]').on('change', function() {
            var kabupatenID = $(this).val();
            if(kabupatenID) {
                $.ajax({
                    url: '/kabupaten/kecamatan/'+kabupatenID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="kecamatan"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="kecamatan"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="kecamatan"]').empty();
            }
        });
    });

    $(document).ready(function() {
        $('select[name="kecamatan"]').on('change', function() {
            var kabupatenID = $(this).val();
            if(kabupatenID) {
                $.ajax({
                    url: '/kecamatan/desa/'+kabupatenID,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        $('select[name="desa"]').empty();
                        $.each(data, function(key, value) {
                            $('select[name="desa"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }else{
                $('select[name="desa"]').empty();
            }
        });
    });
</script>

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
@endpush
