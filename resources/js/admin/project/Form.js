import AppForm from '../app-components/Form/AppForm';

Vue.component('project-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                phone:  '' ,
                sat_id:  '' ,
                state_id:  '' ,
                city_id:  '' ,
                modalidad_id:  '' ,
                leader_name:  '' ,
                localidad:  '' ,
                land_id:  '' ,
                typology_id:  '' ,
                action:  '' ,
                expsocial:  '' ,
                exptecnico:  '' ,
                
            }
        }
    }

});