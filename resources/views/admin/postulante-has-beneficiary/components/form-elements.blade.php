<div class="form-group row align-items-center" :class="{'has-danger': errors.has('postulante_id'), 'has-success': fields.postulante_id && fields.postulante_id.valid }">
    <label for="postulante_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante-has-beneficiary.columns.postulante_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.postulante_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('postulante_id'), 'form-control-success': fields.postulante_id && fields.postulante_id.valid}" id="postulante_id" name="postulante_id" placeholder="{{ trans('admin.postulante-has-beneficiary.columns.postulante_id') }}">
        <div v-if="errors.has('postulante_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('postulante_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('miembro_id'), 'has-success': fields.miembro_id && fields.miembro_id.valid }">
    <label for="miembro_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante-has-beneficiary.columns.miembro_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.miembro_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('miembro_id'), 'form-control-success': fields.miembro_id && fields.miembro_id.valid}" id="miembro_id" name="miembro_id" placeholder="{{ trans('admin.postulante-has-beneficiary.columns.miembro_id') }}">
        <div v-if="errors.has('miembro_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('miembro_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('parentesco_id'), 'has-success': fields.parentesco_id && fields.parentesco_id.valid }">
    <label for="parentesco_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante-has-beneficiary.columns.parentesco_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.parentesco_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('parentesco_id'), 'form-control-success': fields.parentesco_id && fields.parentesco_id.valid}" id="parentesco_id" name="parentesco_id" placeholder="{{ trans('admin.postulante-has-beneficiary.columns.parentesco_id') }}">
        <div v-if="errors.has('parentesco_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('parentesco_id') }}</div>
    </div>
</div>


