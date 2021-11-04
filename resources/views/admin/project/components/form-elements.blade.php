<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project.columns.name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.project.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('phone'), 'has-success': fields.phone && fields.phone.valid }">
    <label for="phone" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project.columns.phone') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.phone" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('phone'), 'form-control-success': fields.phone && fields.phone.valid}" id="phone" name="phone" placeholder="{{ trans('admin.project.columns.phone') }}">
        <div v-if="errors.has('phone')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('phone') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('sat_id'), 'has-success': fields.sat_id && fields.sat_id.valid }">
    <label for="sat_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project.columns.sat_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.sat_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('sat_id'), 'form-control-success': fields.sat_id && fields.sat_id.valid}" id="sat_id" name="sat_id" placeholder="{{ trans('admin.project.columns.sat_id') }}">
        <div v-if="errors.has('sat_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('sat_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('state_id'), 'has-success': fields.state_id && fields.state_id.valid }">
    <label for="state_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project.columns.state_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.state_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('state_id'), 'form-control-success': fields.state_id && fields.state_id.valid}" id="state_id" name="state_id" placeholder="{{ trans('admin.project.columns.state_id') }}">
        <div v-if="errors.has('state_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('state_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('city_id'), 'has-success': fields.city_id && fields.city_id.valid }">
    <label for="city_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project.columns.city_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.city_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('city_id'), 'form-control-success': fields.city_id && fields.city_id.valid}" id="city_id" name="city_id" placeholder="{{ trans('admin.project.columns.city_id') }}">
        <div v-if="errors.has('city_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('city_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('modalidad_id'), 'has-success': fields.modalidad_id && fields.modalidad_id.valid }">
    <label for="modalidad_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project.columns.modalidad_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.modalidad_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('modalidad_id'), 'form-control-success': fields.modalidad_id && fields.modalidad_id.valid}" id="modalidad_id" name="modalidad_id" placeholder="{{ trans('admin.project.columns.modalidad_id') }}">
        <div v-if="errors.has('modalidad_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('modalidad_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('leader_name'), 'has-success': fields.leader_name && fields.leader_name.valid }">
    <label for="leader_name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project.columns.leader_name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.leader_name" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('leader_name'), 'form-control-success': fields.leader_name && fields.leader_name.valid}" id="leader_name" name="leader_name" placeholder="{{ trans('admin.project.columns.leader_name') }}">
        <div v-if="errors.has('leader_name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('leader_name') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('localidad'), 'has-success': fields.localidad && fields.localidad.valid }">
    <label for="localidad" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project.columns.localidad') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.localidad" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('localidad'), 'form-control-success': fields.localidad && fields.localidad.valid}" id="localidad" name="localidad" placeholder="{{ trans('admin.project.columns.localidad') }}">
        <div v-if="errors.has('localidad')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('localidad') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('land_id'), 'has-success': fields.land_id && fields.land_id.valid }">
    <label for="land_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project.columns.land_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.land_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('land_id'), 'form-control-success': fields.land_id && fields.land_id.valid}" id="land_id" name="land_id" placeholder="{{ trans('admin.project.columns.land_id') }}">
        <div v-if="errors.has('land_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('land_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('typology_id'), 'has-success': fields.typology_id && fields.typology_id.valid }">
    <label for="typology_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project.columns.typology_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.typology_id" v-validate="'required|integer'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('typology_id'), 'form-control-success': fields.typology_id && fields.typology_id.valid}" id="typology_id" name="typology_id" placeholder="{{ trans('admin.project.columns.typology_id') }}">
        <div v-if="errors.has('typology_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('typology_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('action'), 'has-success': fields.action && fields.action.valid }">
    <label for="action" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project.columns.action') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.action" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('action'), 'form-control-success': fields.action && fields.action.valid}" id="action" name="action" placeholder="{{ trans('admin.project.columns.action') }}">
        <div v-if="errors.has('action')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('action') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('expsocial'), 'has-success': fields.expsocial && fields.expsocial.valid }">
    <label for="expsocial" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project.columns.expsocial') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.expsocial" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('expsocial'), 'form-control-success': fields.expsocial && fields.expsocial.valid}" id="expsocial" name="expsocial" placeholder="{{ trans('admin.project.columns.expsocial') }}">
        <div v-if="errors.has('expsocial')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('expsocial') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('exptecnico'), 'has-success': fields.exptecnico && fields.exptecnico.valid }">
    <label for="exptecnico" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.project.columns.exptecnico') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.exptecnico" v-validate="''" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('exptecnico'), 'form-control-success': fields.exptecnico && fields.exptecnico.valid}" id="exptecnico" name="exptecnico" placeholder="{{ trans('admin.project.columns.exptecnico') }}">
        <div v-if="errors.has('exptecnico')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('exptecnico') }}</div>
    </div>
</div>


