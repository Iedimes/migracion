<div class="form-group row align-items-center" :class="{'has-danger': errors.has('project_id'), 'has-success': fields.project_id && fields.project_id.valid }">
    <label for="project_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project-has-postulante.columns.project_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.project_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('project_id'), 'form-control-success': fields.project_id && fields.project_id.valid}" id="project_id" name="project_id" placeholder="{{ trans('admin.project-has-postulante.columns.project_id') }}">
        <div v-if="errors.has('project_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('project_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('postulante_id'), 'has-success': fields.postulante_id && fields.postulante_id.valid }">
    <label for="postulante_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project-has-postulante.columns.postulante_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.postulante_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('postulante_id'), 'form-control-success': fields.postulante_id && fields.postulante_id.valid}" id="postulante_id" name="postulante_id" placeholder="{{ trans('admin.project-has-postulante.columns.postulante_id') }}">
        <div v-if="errors.has('postulante_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('postulante_id') }}</div>
    </div>
</div>


