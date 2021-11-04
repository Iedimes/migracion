@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.parentesco.actions.edit', ['name' => $parentesco->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <parentesco-form
                :action="'{{ $parentesco->resource_url }}'"
                :data="{{ $parentesco->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.parentesco.actions.edit', ['name' => $parentesco->name]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.parentesco.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </parentesco-form>

        </div>
    
</div>

@endsection