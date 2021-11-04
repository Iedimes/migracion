<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,
        
    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Project::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'phone' => $faker->sentence,
        'sat_id' => $faker->sentence,
        'state_id' => $faker->sentence,
        'city_id' => $faker->sentence,
        'modalidad_id' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'leader_name' => $faker->sentence,
        'localidad' => $faker->sentence,
        'land_id' => $faker->sentence,
        'typology_id' => $faker->randomNumber(5),
        'action' => $faker->sentence,
        'expsocial' => $faker->sentence,
        'exptecnico' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\ProjectHasExpediente::class, static function (Faker\Generator $faker) {
    return [
        'project_id' => $faker->sentence,
        'exp' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\ProjectHasPostulante::class, static function (Faker\Generator $faker) {
    return [
        'project_id' => $faker->sentence,
        'postulante_id' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Postulante::class, static function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'cedula' => $faker->sentence,
        'marital_status' => $faker->sentence,
        'nacionalidad' => $faker->sentence,
        'gender' => $faker->sentence,
        'birthdate' => $faker->sentence,
        'localidad' => $faker->sentence,
        'asentamiento' => $faker->sentence,
        'ingreso' => $faker->sentence,
        'address' => $faker->sentence,
        'grupo' => $faker->sentence,
        'phone' => $faker->sentence,
        'mobile' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'nexp' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\PostulanteHasBeneficiary::class, static function (Faker\Generator $faker) {
    return [
        'postulante_id' => $faker->sentence,
        'miembro_id' => $faker->sentence,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'parentesco_id' => $faker->randomNumber(5),
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Parentesco::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
