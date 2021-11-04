<div class="form-group row align-items-center" :class="{'has-danger': errors.has('project_id'), 'has-success': fields.project_id && fields.project_id.valid }">
    <label for="project_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project-has-expediente.columns.project_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.project_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('project_id'), 'form-control-success': fields.project_id && fields.project_id.valid}" id="project_id" name="project_id" placeholder="{{ trans('admin.project-has-expediente.columns.project_id') }}">
        <div v-if="errors.has('project_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('project_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('exp'), 'has-success': fields.exp && fields.exp.valid }">
    <label for="exp" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project-has-expediente.columns.exp') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.exp" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('exp'), 'form-control-success': fields.exp && fields.exp.valid}" id="exp" name="exp" placeholder="{{ trans('admin.project-has-expediente.columns.exp') }}">
        <div v-if="errors.has('exp')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('exp') }}</div>
    </div>
</div>


