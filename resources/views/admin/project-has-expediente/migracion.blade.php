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

@if (\Session::has('error'))
    <div class="alert alert-warning">
        <ul>
            <li>{!! \Session::get('error') !!}</li>
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
                <a  ><button class="btn btn-block btn-square btn-lg text-white bg-danger" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-file-pdf-o"></i> MIGRAR A SHD</button></a>
            </div>
        </div>

    </div>
  </div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ingrese N° de Planilla</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url('admin/project-has-expedientes/'.$project->id .'/migracionshd') }}">
      <div class="modal-body">
        <input name="id" type="text">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
      </div>
    </div>
  </div>
</div>



@endsection
