<div class="form-group row align-items-center" :class="{'has-danger': errors.has('first_name'), 'has-success': fields.first_name && fields.first_name.valid }">
    <label for="first_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.first_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.first_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('first_name'), 'form-control-success': fields.first_name && fields.first_name.valid}" id="first_name" name="first_name" placeholder="{{ trans('admin.postulante.columns.first_name') }}">
        <div v-if="errors.has('first_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('first_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('last_name'), 'has-success': fields.last_name && fields.last_name.valid }">
    <label for="last_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.last_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.last_name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('last_name'), 'form-control-success': fields.last_name && fields.last_name.valid}" id="last_name" name="last_name" placeholder="{{ trans('admin.postulante.columns.last_name') }}">
        <div v-if="errors.has('last_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('last_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('cedula'), 'has-success': fields.cedula && fields.cedula.valid }">
    <label for="cedula" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.cedula') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.cedula" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('cedula'), 'form-control-success': fields.cedula && fields.cedula.valid}" id="cedula" name="cedula" placeholder="{{ trans('admin.postulante.columns.cedula') }}">
        <div v-if="errors.has('cedula')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('cedula') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('marital_status'), 'has-success': fields.marital_status && fields.marital_status.valid }">
    <label for="marital_status" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.marital_status') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.marital_status" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('marital_status'), 'form-control-success': fields.marital_status && fields.marital_status.valid}" id="marital_status" name="marital_status" placeholder="{{ trans('admin.postulante.columns.marital_status') }}">
        <div v-if="errors.has('marital_status')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('marital_status') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('nacionalidad'), 'has-success': fields.nacionalidad && fields.nacionalidad.valid }">
    <label for="nacionalidad" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.nacionalidad') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.nacionalidad" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('nacionalidad'), 'form-control-success': fields.nacionalidad && fields.nacionalidad.valid}" id="nacionalidad" name="nacionalidad" placeholder="{{ trans('admin.postulante.columns.nacionalidad') }}">
        <div v-if="errors.has('nacionalidad')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('nacionalidad') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('gender'), 'has-success': fields.gender && fields.gender.valid }">
    <label for="gender" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.gender') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.gender" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('gender'), 'form-control-success': fields.gender && fields.gender.valid}" id="gender" name="gender" placeholder="{{ trans('admin.postulante.columns.gender') }}">
        <div v-if="errors.has('gender')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('gender') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('birthdate'), 'has-success': fields.birthdate && fields.birthdate.valid }">
    <label for="birthdate" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.birthdate') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.birthdate" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('birthdate'), 'form-control-success': fields.birthdate && fields.birthdate.valid}" id="birthdate" name="birthdate" placeholder="{{ trans('admin.postulante.columns.birthdate') }}">
        <div v-if="errors.has('birthdate')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('birthdate') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('localidad'), 'has-success': fields.localidad && fields.localidad.valid }">
    <label for="localidad" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.localidad') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.localidad" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('localidad'), 'form-control-success': fields.localidad && fields.localidad.valid}" id="localidad" name="localidad" placeholder="{{ trans('admin.postulante.columns.localidad') }}">
        <div v-if="errors.has('localidad')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('localidad') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('asentamiento'), 'has-success': fields.asentamiento && fields.asentamiento.valid }">
    <label for="asentamiento" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.asentamiento') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.asentamiento" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('asentamiento'), 'form-control-success': fields.asentamiento && fields.asentamiento.valid}" id="asentamiento" name="asentamiento" placeholder="{{ trans('admin.postulante.columns.asentamiento') }}">
        <div v-if="errors.has('asentamiento')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('asentamiento') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('ingreso'), 'has-success': fields.ingreso && fields.ingreso.valid }">
    <label for="ingreso" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.ingreso') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.ingreso" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('ingreso'), 'form-control-success': fields.ingreso && fields.ingreso.valid}" id="ingreso" name="ingreso" placeholder="{{ trans('admin.postulante.columns.ingreso') }}">
        <div v-if="errors.has('ingreso')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('ingreso') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('address'), 'has-success': fields.address && fields.address.valid }">
    <label for="address" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.address') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.address" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('address'), 'form-control-success': fields.address && fields.address.valid}" id="address" name="address" placeholder="{{ trans('admin.postulante.columns.address') }}">
        <div v-if="errors.has('address')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('address') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('grupo'), 'has-success': fields.grupo && fields.grupo.valid }">
    <label for="grupo" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.grupo') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.grupo" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('grupo'), 'form-control-success': fields.grupo && fields.grupo.valid}" id="grupo" name="grupo" placeholder="{{ trans('admin.postulante.columns.grupo') }}">
        <div v-if="errors.has('grupo')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('grupo') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('phone'), 'has-success': fields.phone && fields.phone.valid }">
    <label for="phone" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.phone') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.phone" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('phone'), 'form-control-success': fields.phone && fields.phone.valid}" id="phone" name="phone" placeholder="{{ trans('admin.postulante.columns.phone') }}">
        <div v-if="errors.has('phone')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('phone') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('mobile'), 'has-success': fields.mobile && fields.mobile.valid }">
    <label for="mobile" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.mobile') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.mobile" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('mobile'), 'form-control-success': fields.mobile && fields.mobile.valid}" id="mobile" name="mobile" placeholder="{{ trans('admin.postulante.columns.mobile') }}">
        <div v-if="errors.has('mobile')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('mobile') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('nexp'), 'has-success': fields.nexp && fields.nexp.valid }">
    <label for="nexp" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.postulante.columns.nexp') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.nexp" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('nexp'), 'form-control-success': fields.nexp && fields.nexp.valid}" id="nexp" name="nexp" placeholder="{{ trans('admin.postulante.columns.nexp') }}">
        <div v-if="errors.has('nexp')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('nexp') }}</div>
    </div>
</div>


