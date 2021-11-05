import AppForm from '../app-components/Form/AppForm';

Vue.component('postulante-has-discapacidad-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                postulante_id:  '' ,
                discapacidad_id:  '' ,
                
            }
        }
    }

});