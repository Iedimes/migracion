import AppForm from '../app-components/Form/AppForm';

Vue.component('project-has-postulante-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                project_id:  '' ,
                postulante_id:  '' ,
                
            }
        }
    }

});