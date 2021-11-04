@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.postulante-has-beneficiary.actions.edit', ['name' => $postulanteHasBeneficiary->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <postulante-has-beneficiary-form
                :action="'{{ $postulanteHasBeneficiary->resource_url }}'"
                :data="{{ $postulanteHasBeneficiary->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.postulante-has-beneficiary.actions.edit', ['name' => $postulanteHasBeneficiary->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.postulante-has-beneficiary.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </postulante-has-beneficiary-form>

        </div>
    
</div>

@endsection