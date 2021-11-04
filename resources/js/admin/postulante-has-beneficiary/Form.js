import AppForm from '../app-components/Form/AppForm';

Vue.component('postulante-has-beneficiary-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                postulante_id:  '' ,
                miembro_id:  '' ,
                parentesco_id:  '' ,
                
            }
        }
    }

});