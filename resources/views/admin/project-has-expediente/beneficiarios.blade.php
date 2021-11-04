@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.project-has-expediente.actions.index'))

@section('body')

<div class="card">
    <div class="card-header text-center">
        DATOS DEL POSTULANTE

        <a class="btn btn-primary btn-spinner btn-sm pull-right m-b-0" href="{{ url()->previous() }}" role="button"><i class="fa fa-undo"></i>&nbsp; {{ trans('admin.guest.actions.back') }}</a>
    </div>

    <div class="card-body">

        <div class="row">
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>Nombre:</strong> {{ $id->postulante->first_name }} </p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>Apellido:</strong> {{ $id->postulante->last_name }}</p>
            </div>
            <div class="form-group col-sm-4">
                <p class="card-text"><strong>Cedula:</strong>  {{ $id->postulante->cedula }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.guest.actions.applicants') }}
                    </div>
                    <div class="card-body" v-cloak>
                        <!--<div class="card-block">-->
                            <table class="table table-sm table-hover table-borderless">
                                <thead>
                                    <tr>
                                    <th class="d-none d-sm-block">#</th>
                                    <th>{{ trans('admin.guest.columns.name') }}</th>
                                    <th>{{ trans('admin.guest.columns.parent') }}</th>
                                    <th class="text-center">{{ trans('admin.guest.columns.ci') }}</th>
                                    <th class="text-center">{{ trans('admin.guest.columns.birthdate') }}</th>
                                    <th class="text-center">{{ trans('admin.guest.columns.ingreso') }}</th>

                                    <!--<th></th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $key=>$item)
                                    <tr>
                                    <th class="d-none d-sm-block" scope="row">{{$key+1}}</th>
                                    <td>{{ $item->miembros->first_name }} {{ $item->miembros->last_name }}</td>
                                    <td>{{ $item->parentesco->name }}</td>
                                    <td class="text-center">{{ $item->miembros->cedula }}</td>
                                    <td class="text-center">{{ $item->miembros->birthdate }}</td>
                                    <td class="text-center">{{ $item->miembros->ingreso }}</td>

                                        <!--<td>
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-spinner btn-info" href="{{ url('admin/project-has-expedientes/beneficiarios/'.$item->id)}}" title="{{ trans('brackets/admin-ui::admin.btn.show') }}" role="button"><i class="fa fa-user"></i></a>
                                                </div>
                                            </div>
                                        </td>-->
                                </tr>

                                    @endforeach
                                </tbody>
                                </table>
                    </div>
                </div>
            </div>
        </div>


@endsection
