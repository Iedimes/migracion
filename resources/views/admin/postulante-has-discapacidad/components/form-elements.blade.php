<div class="form-group row align-items-center" :class="{'has-danger': errors.has('postulante_id'), 'has-success': fields.postulante_id && fields.postulante_id.valid }">
    <label for="postulante_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante-has-discapacidad.columns.postulante_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.postulante_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('postulante_id'), 'form-control-success': fields.postulante_id && fields.postulante_id.valid}" id="postulante_id" name="postulante_id" placeholder="{{ trans('admin.postulante-has-discapacidad.columns.postulante_id') }}">
        <div v-if="errors.has('postulante_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('postulante_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('discapacidad_id'), 'has-success': fields.discapacidad_id && fields.discapacidad_id.valid }">
    <label for="discapacidad_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante-has-discapacidad.columns.discapacidad_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.discapacidad_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('discapacidad_id'), 'form-control-success': fields.discapacidad_id && fields.discapacidad_id.valid}" id="discapacidad_id" name="discapacidad_id" placeholder="{{ trans('admin.postulante-has-discapacidad.columns.discapacidad_id') }}">
        <div v-if="errors.has('discapacidad_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('discapacidad_id') }}</div>
    </div>
</div>


