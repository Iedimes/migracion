import AppForm from '../app-components/Form/AppForm';

Vue.component('postulante-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                first_name:  '' ,
                last_name:  '' ,
                cedula:  '' ,
                marital_status:  '' ,
                nacionalidad:  '' ,
                gender:  '' ,
                birthdate:  '' ,
                localidad:  '' ,
                asentamiento:  '' ,
                ingreso:  '' ,
                address:  '' ,
                grupo:  '' ,
                phone:  '' ,
                mobile:  '' ,
                nexp:  '' ,
                
            }
        }
    }

});