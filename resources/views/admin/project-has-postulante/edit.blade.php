@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.project-has-postulante.actions.edit', ['name' => $projectHasPostulante->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <project-has-postulante-form
                :action="'{{ $projectHasPostulante->resource_url }}'"
                :data="{{ $projectHasPostulante->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.project-has-postulante.actions.edit', ['name' => $projectHasPostulante->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.project-has-postulante.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </project-has-postulante-form>

        </div>
    
</div>

@endsection