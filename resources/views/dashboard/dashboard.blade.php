@extends('dashboard.layouts.app')
@section('title', 'Dashboard')

@section('content')
@if ($message = Session::get('success'))
  <div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>Hi {{ ucwords(Auth::user()->name) }},! {{$message}}</strong>
  </div>
@endif
<div class="row">
  @if(Auth::user()->role == 'admin')
  <div class="col-lg-3 col-xs-6">
    <div class="info-box bg-yellow">
      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Pemilik</span>
        <span class="info-box-number">5,200</span>

        <div class="progress">
          <div class="progress-bar" style="width: 50%"></div>
        </div>
        <span class="progress-description">
          50% Increase in 30 Days
        </span>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <div class="info-box bg-green">
      <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Pelanggan</span>
        <span class="info-box-number">92,050</span>

        <div class="progress">
          <div class="progress-bar" style="width: 20%"></div>
        </div>
        <span class="progress-description">
          20% Increase in 30 Days
        </span>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <div class="info-box bg-red">
      <span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Orders</span>
        <span class="info-box-number">114,381</span>

        <div class="progress">
          <div class="progress-bar" style="width: 70%"></div>
        </div>
        <span class="progress-description">
          70% Increase in 30 Days
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <div class="info-box bg-aqua">
      <span class="info-box-icon"><i class="ion-ios-chatbubble-outline"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Transaksi</span>
        <span class="info-box-number">163,921</span>

        <div class="progress">
          <div class="progress-bar" style="width: 40%"></div>
        </div>
        <span class="progress-description">
          40% Increase in 30 Days
        </span>
      </div>
    </div>
  </div>
  @endif
  @if(Auth::user()->role == 'pemilik')
  <div class="col-md-12">
    <!-- <div class="callout callout-warning">
      <h4>Informasi!</h4>
      <p>Add the layout-top-nav class to the body tag to get this layout. This feature can also be used with a
        sidebar! So use this class if you want to remove the custom dropdown menus from the navbar and use regular
        links instead.</p>
    </div> -->
    <div class="col-lg-3 col-xs-6">
    <div class="info-box bg-yellow">
      <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Pemilik</span>
        <span class="info-box-number">5,200</span>

        <div class="progress">
          <div class="progress-bar" style="width: 50%"></div>
        </div>
        <span class="progress-description">
          50% Increase in 30 Days
        </span>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <div class="info-box bg-green">
      <span class="info-box-icon"><i class="ion ion-ios-heart-outline"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Pelanggan</span>
        <span class="info-box-number">92,050</span>

        <div class="progress">
          <div class="progress-bar" style="width: 20%"></div>
        </div>
        <span class="progress-description">
          20% Increase in 30 Days
        </span>
      </div>
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <div class="info-box bg-red">
      <span class="info-box-icon"><i class="ion ion-ios-cloud-download-outline"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Orders</span>
        <span class="info-box-number">114,381</span>

        <div class="progress">
          <div class="progress-bar" style="width: 70%"></div>
        </div>
        <span class="progress-description">
          70% Increase in 30 Days
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
  </div>
  <div class="col-lg-3 col-xs-6">
    <div class="info-box bg-aqua">
      <span class="info-box-icon"><i class="ion-ios-chatbubble-outline"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Transaksi</span>
        <span class="info-box-number">163,921</span>

        <div class="progress">
          <div class="progress-bar" style="width: 40%"></div>
        </div>
        <span class="progress-description">
          40% Increase in 30 Days
        </span>
      </div>
    </div>
  </div>
  </div>
  @endif
</div>
@endsection

@push('header')

@endpush

@push('footer')

@endpush