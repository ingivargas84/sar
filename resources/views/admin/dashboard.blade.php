@extends('admin.layoutadmin')

@section('content')

<h1>Dashboard</h1>
<div class="col-lg-3 col-xs-6">
    <!-- small box -->
    <div class="small-box bg-red">
      <div class="inner">
        <h3>{{$users->count()}}</h3>

        <p>Usuarios Registrados</p>
      </div>
      <div class="icon">
        <i class="ion ion-person-add"></i>
      </div>
      <a href="#" class="small-box-footer">
        Mas info <i class="fa fa-arrow-circle-right"></i>
      </a>
    </div>
  </div>

@stop