@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.project-has-expediente.actions.index'))

@section('body')

@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-header text-center">
         MIGRACION DE DATOS

         <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url()->previous() }}" role="button"><i class="fa fa-undo"></i>&nbsp; {{ trans('admin.guest.actions.back') }}</a>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>PROYECTO:</strong> {{$project->name }} </p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>SAT:</strong> {{$project->sat_id }}</p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>Postulantes:</strong>  {{$project->postulantes_count }}</p>
            </div>
        </div>

    </div>
  </div>

  <div class="card">
    <div class="card-header text-center">
         OPCIONES
    </div>

    <div class="card-body">

        <div class="row">
            <div class="form-group col-sm-4">
                <a href="{{ url('admin/project-has-expedientes/'.$project->id .'/migracionpersonas') }}" class="btn btn-block btn-square btn-lg text-white bg-danger"><i class="fa fa-file-pdf-o"></i> MIGRAR A PERSONAS</a>
            </div>
            <div class="form-group col-sm-4">
                <a href="{{ url('admin/project-has-expedientes/'.$project->id .'/migracionsolicitantes') }}"  class="btn btn-block btn-square btn-lg text-white bg-danger"><i class="fa fa-file-pdf-o"></i> MIGRAR A SOLICITANTES</a>
            </div>
            <div class="form-group col-sm-4">
                <a href="{{ url('admin/project-has-expedientes//migracion') }}" class="btn btn-block btn-square btn-lg text-white bg-danger"><i class="fa fa-file-pdf-o"></i> MIGRAR A SHD</a>
            </div>
        </div>

    </div>
  </div>



@endsection
