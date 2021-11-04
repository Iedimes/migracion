import AppForm from '../app-components/Form/AppForm';

Vue.component('project-has-expediente-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                project_id:  '' ,
                exp:  '' ,
                
            }
        }
    }

});