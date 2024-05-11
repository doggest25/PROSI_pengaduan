
@extends('layout.template')



@section('content')

    <!-- Widget: user widget style 1 -->
    <div class="card card-widget widget-user">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header text-white"
           style="background: url('adminlte/dist/img/photo1.png') center center;">
        <h3 class="widget-user-username text-right">Elizabeth Pierce</h3>
        <h5 class="widget-user-desc text-right">Web Designer</h5>
      </div>
      <div class="widget-user-image">
        <img class="img-circle" src="{{asset('adminlte/logo/page.png')}}" alt="User Avatar">
      </div>
      <div class="card-footer">
        <div class="row">
          <div class="col-sm-4 border-right">
            <div class="description-block">
              <h5 class="description-header">089512097078</h5>
              <span class="description-text">Contact</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-4 border-right">
            <div class="description-block">
              <h5 class="description-header">13,000</h5>
              <span class="description-text">Social Media</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-4">
            <div class="description-block">
              <h5 class="description-header">35</h5>
              <span class="description-text">Partner</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
    </div>
    <!-- /.widget-user -->
  
@endsection