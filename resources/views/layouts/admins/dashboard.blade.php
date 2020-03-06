@extends('layouts.admins.app')
@section('content')
  <div class="container-fluid">
    <div class="block-header">
        <h2>DASHBOARD</h2>
    </div>

    <!-- Widgets -->
    <div class="row clearfix">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-green hover-expand-effect">
                <div class="icon">
                    <i class="material-icons">people</i>
                </div>
                <div class="content">
                    <div class="text">Users</div>
                    <div class="number count-to" data-from="0" data-to="{{ $total_users }}" data-speed="15" data-fresh-interval="20">{{ $total_users }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Widgets -->
    <div class="row clearfix">
      <!-- Task Info -->
      
      <!-- #END# Task Info -->
      <!-- Browser Usage -->
      <!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
          <div class="card">
              <div class="header">
                  <h2>Something here</h2>
              </div>
              <div class="body">
                Some description eher.
              </div>
          </div>
      </div> -->
      <!-- #END# Browser Usage -->
    </div>
  </div>
@endsection
