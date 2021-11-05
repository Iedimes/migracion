<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'project' => [
        'title' => 'Projects',

        'actions' => [
            'index' => 'Projects',
            'create' => 'New Project',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'sat_id' => 'Sat',
            'state_id' => 'State',
            'city_id' => 'City',
            'modalidad_id' => 'Modalidad',
            'leader_name' => 'Leader name',
            'localidad' => 'Localidad',
            'land_id' => 'Land',
            'typology_id' => 'Typology',
            'action' => 'Action',
            'expsocial' => 'Expsocial',
            'exptecnico' => 'Exptecnico',
            
        ],
    ],

    'project-has-expediente' => [
        'title' => 'Project Has Expedientes',

        'actions' => [
            'index' => 'Project Has Expedientes',
            'create' => 'New Project Has Expediente',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'project_id' => 'Project',
            'exp' => 'Exp',
            
        ],
    ],

    'project-has-postulante' => [
        'title' => 'Project Has Postulantes',

        'actions' => [
            'index' => 'Project Has Postulantes',
            'create' => 'New Project Has Postulante',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'project_id' => 'Project',
            'postulante_id' => 'Postulante',
            
        ],
    ],

    'postulante' => [
        'title' => 'Postulantes',

        'actions' => [
            'index' => 'Postulantes',
            'create' => 'New Postulante',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'cedula' => 'Cedula',
            'marital_status' => 'Marital status',
            'nacionalidad' => 'Nacionalidad',
            'gender' => 'Gender',
            'birthdate' => 'Birthdate',
            'localidad' => 'Localidad',
            'asentamiento' => 'Asentamiento',
            'ingreso' => 'Ingreso',
            'address' => 'Address',
            'grupo' => 'Grupo',
            'phone' => 'Phone',
            'mobile' => 'Mobile',
            'nexp' => 'Nexp',
            
        ],
    ],

    'postulante-has-beneficiary' => [
        'title' => 'Postulante Has Beneficiaries',

        'actions' => [
            'index' => 'Postulante Has Beneficiaries',
            'create' => 'New Postulante Has Beneficiary',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'postulante_id' => 'Postulante',
            'miembro_id' => 'Miembro',
            'parentesco_id' => 'Parentesco',
            
        ],
    ],

    'parentesco' => [
        'title' => 'Parentesco',

        'actions' => [
            'index' => 'Parentesco',
            'create' => 'New Parentesco',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Name',
            
        ],
    ],

    'postulante-has-discapacidad' => [
        'title' => 'Postulante Has Discapacidad',

        'actions' => [
            'index' => 'Postulante Has Discapacidad',
            'create' => 'New Postulante Has Discapacidad',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'postulante_id' => 'Postulante',
            'discapacidad_id' => 'Discapacidad',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];