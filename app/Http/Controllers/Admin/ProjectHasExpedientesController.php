<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectHasExpediente\BulkDestroyProjectHasExpediente;
use App\Http\Requests\Admin\ProjectHasExpediente\DestroyProjectHasExpediente;
use App\Http\Requests\Admin\ProjectHasExpediente\IndexProjectHasExpediente;
use App\Http\Requests\Admin\ProjectHasExpediente\StoreProjectHasExpediente;
use App\Http\Requests\Admin\ProjectHasExpediente\UpdateProjectHasExpediente;
use App\Models\BAMPER;
use App\Models\IVMSOL;
use App\Models\IVMSOL2;
use App\Models\POSSVS;
use App\Models\POSSVS1;
use Illuminate\Support\Facades\Auth;
use App\Models\Postulante;
use App\Models\PostulanteHasBeneficiary;
use App\Models\Project;
use App\Models\ProjectHasExpediente;
use App\Models\ProjectHasPostulante;
use App\Models\SIG005L1;
use App\Models\Land;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProjectHasExpedientesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexProjectHasExpediente $request
     * @return array|Factory|View
     */
    public function index(IndexProjectHasExpediente $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ProjectHasExpediente::class)->processRequestAndGet(
            $request,
            ['id', 'project_id', 'exp'],
            ['project_id', 'exp'],
            function ($query) {
                // Solo incluir los registros que tienen un project asociado
                $query->whereHas('project');
            }
        );


        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        //return $data;
        return view('admin.project-has-expediente.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.project-has-expediente.create');

        return view('admin.project-has-expediente.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectHasExpediente $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreProjectHasExpediente $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ProjectHasExpediente
        $projectHasExpediente = ProjectHasExpediente::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/project-has-expedientes'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/project-has-expedientes');
    }

    /**
     * Display the specified resource.
     *
     * @param ProjectHasExpediente $projectHasExpediente
     * @throws AuthorizationException
     * @return void
     */
    public function show(ProjectHasExpediente $projectHasExpediente)
    {
        $this->authorize('admin.project-has-expediente.show', $projectHasExpediente);

        // $postulantes = ProjectHasPostulante::where('project_id', $projectHasExpediente->project_id)->get();
        $postulantes = ProjectHasPostulante::where('project_id', $projectHasExpediente->project_id)
                        ->whereNull('deleted_at')
                        ->get();
        //return $postulantes;
        // TODO your code goes here
        return view('admin.project-has-expediente.show', compact('projectHasExpediente', 'postulantes'));
    }

    public function migracion($projectHasExpediente)
    {
        //$this->authorize('admin.project-has-expediente.show', $projectHasExpediente);
        $project = Project::find($projectHasExpediente);
        //return $project;
        return view('admin.project-has-expediente.migracion', compact('project'));
    }

    public function migracionpersonas($projectHasExpediente)
    {
        $postulantes = ProjectHasPostulante::where('project_id', $projectHasExpediente)
                                    ->whereNull('deleted_at')
                                    ->get();
        $date = new \DateTime();
        $email = Auth::user()->email;

        // Extraer y preparar el username una sola vez
        $username = strstr($email, '@', true);
        $perUser = strtoupper(substr($username, 0, 8)) . '-M';

        // Arrays de mapeo
        $estciv = [
            'SO' => 1, 'CA' => 2, 'SE' => 3, 'DI' => 4, 'VI' => 6, 'ME' => 7,
        ];
        $relpar = [
            'SO' => 1, 'CA' => 2, 'SE' => 3, 'DI' => 4, 'VI' => 6, 'ME' => 7,
        ];

        // Contadores y arrays de detalles
        $contadores = [
            'insertados' => 0,
            'ya_existian' => 0,
            'errores' => 0,
            'estado_civil_invalido' => 0
        ];

        $detalles = [
            'ya_existian' => [],
            'errores' => [],
            'estado_civil_invalido' => []
        ];

        foreach ($postulantes as $key => $value) {
            // Procesar postulante principal
            $resultado = $this->procesarPersona($value->postulante, $estciv, $relpar, $perUser, $date, 'postulante', $detalles);
            $contadores[$resultado]++;

            // Procesar miembros
            if (count($value->members) > 0) {
                foreach ($value->members as $member) {
                    $resultado = $this->procesarPersona($member->miembros, $estciv, $relpar, $perUser, $date, 'miembro', $detalles);
                    $contadores[$resultado]++;
                }
            }
        }

        // Preparar mensaje de feedback
        $mensaje = $this->construirMensajeFeedback($contadores, $detalles);

        return redirect()->back()->with('success', $mensaje);
    }

    private function procesarPersona($persona, $estciv, $relpar, $perUser, $date, $tipo, &$detalles)
    {
        try {
            // Verificar si ya existe
            $existePersona = BAMPER::where('PerCod', $persona->cedula)->first();
            if ($existePersona) {
                \Log::info("Persona ya existe: {$persona->cedula} - {$persona->first_name} {$persona->last_name}");
                $detalles['ya_existian'][] = [
                    'cedula' => $persona->cedula,
                    'nombre' => $persona->first_name . ' ' . $persona->last_name,
                    'tipo' => $tipo
                ];
                return 'ya_existian';
            }

            // Validar estado civil
            $maritalStatus = $persona->marital_status;
            if (!isset($estciv[$maritalStatus])) {
                \Log::warning("Estado civil no encontrado: {$maritalStatus} para cédula: {$persona->cedula}");
                $detalles['estado_civil_invalido'][] = [
                    'cedula' => $persona->cedula,
                    'nombre' => $persona->first_name . ' ' . $persona->last_name,
                    'estado_civil' => $maritalStatus,
                    'tipo' => $tipo
                ];
                return 'estado_civil_invalido';
            }

            // Preparar datos comunes
            $datosComunes = $this->prepararDatosPersona($persona, $estciv, $relpar, $perUser, $date, $maritalStatus);

            // Crear registro
            $reg = BAMPER::create($datosComunes);

            \Log::info("Persona insertada: {$persona->cedula} - {$persona->first_name} {$persona->last_name} (Tipo: {$tipo})");
            return 'insertados';

        } catch (\Exception $e) {
            \Log::error("Error al procesar persona {$persona->cedula}: " . $e->getMessage());
            $detalles['errores'][] = [
                'cedula' => $persona->cedula,
                'nombre' => $persona->first_name . ' ' . $persona->last_name,
                'error' => $e->getMessage(),
                'tipo' => $tipo
            ];
            return 'errores';
        }
    }

    private function prepararDatosPersona($persona, $estciv, $relpar, $perUser, $date, $maritalStatus)
    {
        $nombre = $persona->last_name . ' ' . $persona->first_name;
        $nac = new \DateTime($persona->birthdate);
        $f = date_format($nac, 'Ymd');

        // Procesar nombres y apellidos
        $nomseg = str_contains($persona->first_name, ' ') ?
            substr($persona->first_name, strpos($persona->first_name, " ") + 1) : "";
        $apeseg = str_contains($persona->last_name, ' ') ?
            substr($persona->last_name, strpos($persona->last_name, " ") + 1) : "";

        $apepri = strtok($persona->last_name, ' ');
        $nompri = strtok($persona->first_name, ' ');

        return [
            'PerCod' => $persona->cedula,
            'PerNom' => $nombre,
            'PerApePri' => $apepri,
            'PerNomPri' => $nompri,
            'PerApeSeg' => $apeseg,
            'PerNomSeg' => $nomseg,
            'PerDomic' => substr($persona->address ?? '', 0, 60),
            'PerTel1' => $persona->phone,
            'PerTel2' => $persona->mobile,
            'PerEstCiv' => $estciv[$maritalStatus],
            'PerTpDoc' => 'CID',
            'PerFchNac' => $f,
            'PerSexo' => $persona->gender,
            'ProCod' => 58,
            'ActCod' => 7,
            'PerNac' => 1,
            'DptoId' => 11,
            'CiuId' => 179,
            'PerRelPar' => $relpar[$maritalStatus],
            'PerFUM' => date_format($date, 'Ymd H:i:s'),
            'PerUser' => $perUser
        ];
    }

    private function construirMensajeFeedback($contadores, $detalles)
    {
        $mensajes = [];

        if ($contadores['insertados'] > 0) {
            $mensajes[] = "✅ {$contadores['insertados']} personas insertadas correctamente";
        }

        if ($contadores['ya_existian'] > 0) {
            $mensajes[] = "⚠️ {$contadores['ya_existian']} personas ya existían en la base de datos";
        }

        if ($contadores['estado_civil_invalido'] > 0) {
            $mensajes[] = "❌ {$contadores['estado_civil_invalido']} personas omitidas por estado civil inválido";
        }

        if ($contadores['errores'] > 0) {
            $mensajes[] = "🔴 {$contadores['errores']} personas con errores durante la inserción";
        }

        $total = array_sum($contadores);
        $titulo = "MIGRACIÓN PERSONAS COMPLETADA - Total procesadas: {$total}";

        return $titulo . "\n\n" . implode("\n", $mensajes);
    }







    public function migracionsolicitantes($projectHasExpediente)
    {
        $postulantes = ProjectHasPostulante::where('project_id', $projectHasExpediente)
                        ->whereNull('deleted_at')
                        ->get();

        $exp = ProjectHasExpediente::where('project_id', $projectHasExpediente)->first();
        $date = new \DateTime();
        $email = Auth::user()->email;
        $userCode = strtoupper(substr(strstr($email, '@', true), 0, 8)) . '-M';

        // Array de mapeo de parentescos
        $parent = [
            1 => 1,   // Esposo/a
            2 => 3,   // Hermano/a
            3 => 2,   // Hijo/a
            4 => 4,   // Padre/Madre
            7 => 9,   // Sobrino/a
            8 => 1,   // Concubino/a
            9 => 5,   // Abuelo/a
            10 => 6,  // Tío/a
            11 => 5,  // Nieto/a
            14 => 10  // Yerno/Nuera
        ];


        // Contadores y detalles para feedback
        $contadores = [
            'solicitantes_insertados' => 0,
            'solicitantes_actualizados' => 0,
            'grupos_insertados' => 0,
            'grupos_actualizados' => 0,
            'miembros_insertados' => 0,
            'miembros_actualizados' => 0,
            'errores' => 0,
            'mesa_no_encontrada' => 0,
            'persona_no_encontrada' => 0
        ];

        $detalles = [
            'errores' => [],
            'mesa_no_encontrada' => [],
            'persona_no_encontrada' => []
        ];

        foreach ($postulantes as $postulante) {
            $resultado = $this->procesarSolicitante($postulante, $exp, $parent, $userCode, $date, $contadores, $detalles);
        }

        $mensaje = $this->construirMensajeFeedbackSolicitantes($contadores, $detalles);
        return redirect()->back()->with('success', $mensaje);
    }

    private function procesarSolicitante($postulante, $exp, $parent, $userCode, $date, &$contadores, &$detalles)
    {
        try {
            // Buscar datos de mesa
            $mesa = SIG005L1::where('ExpDPerCod', $postulante->postulante->cedula)
                ->where('NroExp', $exp->exp)
                ->first();

            if (!$mesa) {
                $detalles['mesa_no_encontrada'][] = [
                    'cedula' => $postulante->postulante->cedula,
                    'nombre' => $postulante->postulante->first_name . ' ' . $postulante->postulante->last_name,
                    'exp' => $exp->exp
                ];
                $contadores['mesa_no_encontrada']++;
                return;
            }

            // Procesar solicitante principal
            $this->procesarIVMSOL($postulante, $mesa, $exp, $userCode, $date, $contadores);

            // Procesar grupo familiar (postulante principal)
            $this->procesarGrupoFamiliar($postulante->postulante, $postulante->postulante->cedula,
                                    $mesa, 8, $userCode, $date, $contadores, $detalles);

            // Procesar miembros
            if (count($postulante->members) > 0) {
                foreach ($postulante->members as $member) {
                    $parentCod = $parent[$member->parentesco->id] ?? 1;
                    $this->procesarGrupoFamiliar($member->miembros, $postulante->postulante->cedula,
                                            $mesa, $parentCod, $userCode, $date, $contadores, $detalles);
                }
            }

        } catch (\Exception $e) {
            \Log::error("Error procesando solicitante {$postulante->postulante->cedula}: " . $e->getMessage());
            $detalles['errores'][] = [
                'cedula' => $postulante->postulante->cedula,
                'nombre' => $postulante->postulante->first_name . ' ' . $postulante->postulante->last_name,
                'error' => $e->getMessage()
            ];
            $contadores['errores']++;
        }
    }

    private function procesarIVMSOL($postulante, $mesa, $exp, $userCode, $date, &$contadores)
    {
        $expfec = new \DateTime($mesa->ExpDFec);
        $solpercge = $postulante->conyuge ? $postulante->conyuge->miembros->cedula : '';

        $datosIVMSOL = [
            'SolPerCod' => $postulante->postulante->cedula,
            'SolSer' => substr($mesa->ExpDNro, -2),
            'SolNro' => substr($mesa->ExpDNro, 0, -2),
            'SolFch' => date_format($expfec, 'Ymd H:i:s'),
            'SolTieUni' => '',
            'SolAuto' => 'N',
            'SolEquipo' => 'N',
            'SolMaquin' => 'N',
            'SolAnimal' => 'N',
            'SolOtros' => '',
            'SolTipo' => 12,
            'SolInscri' => $userCode,
            'SolComent' => "Exp. Social: " . $exp->exp . " Codigo de Proyecto: " . $exp->project_id,
            'SolPerCge' => $solpercge,
            'SolHabViv' => '',
            'SolFum' => date_format($date, 'Ymd H:i:s'),
            'SolEtapa' => 'S',
            'SolReFecAd' => null,
            'SolReNroAd' => null,
            'SolCodObra' => null,
        ];

        $existeSolicitante = IVMSOL::where('SolPerCod', $postulante->postulante->cedula)->first();

        if ($existeSolicitante) {
            $existeSolicitante->update($datosIVMSOL);
            $contadores['solicitantes_actualizados']++;
            \Log::info("Solicitante actualizado: {$postulante->postulante->cedula}");
        } else {
            IVMSOL::create($datosIVMSOL);
            $contadores['solicitantes_insertados']++;
            \Log::info("Solicitante insertado: {$postulante->postulante->cedula}");
        }
    }

    private function procesarGrupoFamiliar($persona, $solPerCod, $mesa, $parentCod, $userCode, $date, &$contadores, &$detalles)
    {
        $personaBamper = BAMPER::where('PerCod', $persona->cedula)->first();
        if (!$personaBamper) {
            $detalles['persona_no_encontrada'][] = [
                'cedula' => $persona->cedula,
                'nombre' => $persona->first_name . ' ' . $persona->last_name,
                'motivo' => 'No encontrada en BAMPER'
            ];
            $contadores['persona_no_encontrada']++;
            return;
        }

        $datecalc = new \DateTime($personaBamper->PerFchNac);
        $now = new \DateTime($mesa->ExpDFec);
        $interval = $now->diff($datecalc);

        $dis = $this->determinarDiscapacidad($persona);

        \Log::info("=== ANTES DE PROCESAR MONTO ===");
        \Log::info("Persona: {$persona->cedula}");
        \Log::info("Ingreso crudo: " . var_export($persona->ingreso, true));

        $montoProcesado = $this->procesarMonto($persona->ingreso);

        \Log::info("Monto procesado: " . var_export($montoProcesado, true));
        \Log::info("Tipo de dato del monto procesado: " . gettype($montoProcesado));

        $datosGrupoFamiliar = [
            'GfsEdad' => $interval->y,
            'ParCod' => $parentCod,
            'GfsDis' => $dis,
            'GfsImpSue' => $montoProcesado,
            'GfsImpApo' => 0.00,
            'GfsUsuCod' => $userCode,
            'GfsFecAlta' => date_format($date, 'Ymd H:i:s'),
            'GfsPEC' => 'N',
        ];

        $existeGrupo = IVMSOL2::where('SolPerCod', $solPerCod)
                            ->where('GfsCod', $persona->cedula)
                            ->first();

        if ($existeGrupo) {
            \Log::info("🟡 Forzando update en BD con:");
            \Log::info(print_r($datosGrupoFamiliar, true));

            \DB::connection('sqlsrv')->table('IVMSOL2')
        ->where('SolPerCod', $solPerCod)
        ->where('GfsCod', $persona->cedula)
        ->update($datosGrupoFamiliar);


            $registroActualizado = IVMSOL2::where('SolPerCod', $solPerCod)
                                        ->where('GfsCod', $persona->cedula)
                                        ->first();
            \Log::info("=== DESPUÉS DEL UPDATE ===");
            \Log::info("Persona: {$persona->cedula}");
            \Log::info("GfsImpSue guardado: " . var_export($registroActualizado->GfsImpSue, true));

            if ($parentCod == 8) {
                $contadores['grupos_actualizados']++;
            } else {
                $contadores['miembros_actualizados']++;
            }
            \Log::info("Grupo familiar actualizado: {$persona->cedula} para solicitante: {$solPerCod}");
        } else {
            IVMSOL2::create([
                'SolPerCod' => $solPerCod,
                'GfsCod' => $persona->cedula,
            ] + $datosGrupoFamiliar);

            if ($parentCod == 8) {
                $contadores['grupos_insertados']++;
            } else {
                $contadores['miembros_insertados']++;
            }
            \Log::info("Grupo familiar insertado: {$persona->cedula} para solicitante: {$solPerCod}");
        }
    }


    private function determinarDiscapacidad($persona)
    {
        if (!isset($persona->discapacidad) ||
            $persona->discapacidad->discapacidad_id == null ||
            $persona->discapacidad->discapacidad_id == '') {
            return 'S'; // Sin discapacidad
        } elseif ($persona->discapacidad->discapacidad_id == 1) {
            return 'N'; // Con discapacidad
        } else {
            return 'S'; // Sin discapacidad
        }
    }

        private function procesarMonto($monto)
    {
        \Log::info("🔎 procesarMonto recibido: " . var_export($monto, true));

        if (is_null($monto) || $monto === '' || $monto === 0 || $monto === '0,00' || $monto === '0.00') {
            return 0.00;
        }

        if (is_string($monto)) {
            // Caso "1.250.000,00"
            if (preg_match('/^[\d.]+,\d{2}$/', $monto)) {
                $monto = str_replace('.', '', $monto);
                $monto = str_replace(',', '.', $monto);
            } elseif (strpos($monto, ',') !== false) {
                // Caso "2500,00"
                $monto = str_replace(',', '.', $monto);
            }
        }

        $valorFinal = (float) number_format(floatval($monto), 2, '.', '');
        \Log::info("🔁 procesarMonto procesado: {$valorFinal}");

        return $valorFinal;
    }





    private function construirMensajeFeedbackSolicitantes($contadores, $detalles)
    {
        $mensajes = [];

        // Resultados exitosos
        if ($contadores['solicitantes_insertados'] > 0) {
            $mensajes[] = "✅ {$contadores['solicitantes_insertados']} solicitantes insertados";
        }
        if ($contadores['solicitantes_actualizados'] > 0) {
            $mensajes[] = "🔄 {$contadores['solicitantes_actualizados']} solicitantes actualizados";
        }
        if ($contadores['grupos_insertados'] > 0) {
            $mensajes[] = "✅ {$contadores['grupos_insertados']} grupos familiares insertados";
        }
        if ($contadores['grupos_actualizados'] > 0) {
            $mensajes[] = "🔄 {$contadores['grupos_actualizados']} grupos familiares actualizados";
        }
        if ($contadores['miembros_insertados'] > 0) {
            $mensajes[] = "✅ {$contadores['miembros_insertados']} miembros insertados";
        }
        if ($contadores['miembros_actualizados'] > 0) {
            $mensajes[] = "🔄 {$contadores['miembros_actualizados']} miembros actualizados";
        }

        // Problemas encontrados
        if ($contadores['mesa_no_encontrada'] > 0) {
            $mensaje = "⚠️ {$contadores['mesa_no_encontrada']} solicitantes sin datos de mesa";
            if (!empty($detalles['mesa_no_encontrada'])) {
                $cedulas = array_map(function($item) {
                    return $item['cedula'] . ' (' . $item['nombre'] . ') - Exp: ' . $item['exp'];
                }, $detalles['mesa_no_encontrada']);
                $mensaje .= ":\n   " . implode("\n   ", $cedulas);
            }
            $mensajes[] = $mensaje;
        }

        if ($contadores['persona_no_encontrada'] > 0) {
            $mensaje = "⚠️ {$contadores['persona_no_encontrada']} personas no encontradas en BAMPER";
            if (!empty($detalles['persona_no_encontrada'])) {
                $cedulas = array_map(function($item) {
                    return $item['cedula'] . ' (' . $item['nombre'] . ')';
                }, $detalles['persona_no_encontrada']);
                $mensaje .= ":\n   " . implode("\n   ", $cedulas);
            }
            $mensajes[] = $mensaje;
        }

        if ($contadores['errores'] > 0) {
            $mensaje = "🔴 {$contadores['errores']} errores durante el procesamiento";
            if (!empty($detalles['errores'])) {
                $cedulas = array_map(function($item) {
                    return $item['cedula'] . ' (' . $item['nombre'] . ') - Error: ' . substr($item['error'], 0, 50) . '...';
                }, $detalles['errores']);
                $mensaje .= ":\n   " . implode("\n   ", $cedulas);
            }
            $mensajes[] = $mensaje;
        }

        $totalProcesados = $contadores['solicitantes_insertados'] + $contadores['solicitantes_actualizados'] +
                        $contadores['grupos_insertados'] + $contadores['grupos_actualizados'] +
                        $contadores['miembros_insertados'] + $contadores['miembros_actualizados'];

        $titulo = "MIGRACIÓN DE SOLICITANTES COMPLETADA - Total procesados: {$totalProcesados}";

        return $titulo . "\n\n" . implode("\n\n", $mensajes);
    }



    public function migracionshd($projectHasExpediente, Request $request)
    {
        try {
            $Nomproy = Project::where('id', $projectHasExpediente)->first(); // nombre del proyecto y SAT
            $tipoterreno = Land::where('id', $Nomproy->land_id)->first(); // tipo de terreno
            $reg = POSSVS::where('PsvCod', $request->id)->first();
            $exp = ProjectHasExpediente::where('project_id', $projectHasExpediente)->first();
            $date = new \DateTime();
            $email = Auth::user()->email;
            $username = strstr($email, '@', true);
            $perUser = strtoupper(substr($username, 0, 8)) . '-M';

            if (!$reg) {
                return redirect()->back()->with('error', 'No se encontró planilla SHD!');
            }

            // Actualizar registro principal
            $this->updateMainRecord($reg, $Nomproy, $request->id);

            // Procesar postulantes
            $result = $this->processPostulantes($projectHasExpediente, $request->id, $exp, $tipoterreno, $perUser);

            if ($result['success']) {
                return redirect()->back()->with('success',
                    "Datos Migrados Correctamente! ({$result['processed']}/{$result['total']} procesados)");
            } else {
                return redirect()->back()->with('warning',
                    "Migración parcial: {$result['processed']}/{$result['total']} procesados. Revisar logs.");
            }

        } catch (\Exception $e) {
            Log::error("Error general en migración: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Ocurrió un error al migrar los datos.');
        }
    }

    private function updateMainRecord($reg, $Nomproy, $requestId)
    {
        POSSVS::where('PsvCod', $reg->PsvCod)->update([
            'PsvModDes' => trim($Nomproy->name),
            'NucCod' => trim($Nomproy->sat_id),
            'PsvDptoId' => $Nomproy->state_id,
            'PsvCiudId' => $Nomproy->city_id
        ]);
    }

    private function processPostulantes($projectId, $requestId, $exp, $tipoterreno, $perUser)
    {
        $postulantes = ProjectHasPostulante::with([
            'postulante.discapacidad',
            'conyuge.miembros'
        ])
        ->where('project_id', $projectId)
        ->whereNull('deleted_at')
        ->get();


        $processed = 0;
        $errors = 0;
        $total = $postulantes->count();

        foreach ($postulantes as $key => $postulante) {
            try {
                if ($this->processIndividualPostulante($postulante, $key, $requestId, $exp, $tipoterreno, $perUser)) {
                    $processed++;
                }
            } catch (\Exception $e) {
                $errors++;
                Log::error("Error al procesar postulante {$postulante->id}: " . $e->getMessage(), [
                    'postulante_id' => $postulante->id,
                    'cedula' => $postulante->postulante->cedula ?? 'N/A',
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        return [
            'success' => $errors === 0,
            'processed' => $processed,
            'total' => $total,
            'errors' => $errors
        ];
    }

    private function processIndividualPostulante($postulante, $key, $requestId, $exp, $tipoterreno, $perUser)
    {
        Log::info("Procesando postulante ID {$postulante->id}");

        // Verificar si ya existe
        $existingUser = POSSVS1::where('PsvCedTit', $postulante->postulante->cedula)
            ->where('PsvCod', $requestId)
            ->first();

        if ($existingUser) {
            Log::info("Postulante ya existe: {$postulante->postulante->cedula}");
            return false;
        }

        // Verificar mesa
        $mesa = SIG005L1::where('ExpDPerCod', $postulante->postulante->cedula)
            ->where('NroExp', $exp->exp ?? null)
            ->first();

        if (!$mesa) {
            Log::warning("No se encontró 'mesa' para {$postulante->postulante->cedula}");
            return false;
        }

        // Preparar datos del cónyuge
        $conyugeData = $this->prepareConyugeData($postulante->conyuge);

        // Preparar datos del postulante
        $postulanteData = $this->preparePostulanteData(
            $postulante,
            $key,
            $requestId,
            $mesa,
            $conyugeData,
            $tipoterreno,
            $perUser
        );

        Log::debug("Datos a insertar para cedula {$postulante->postulante->cedula}:", $postulanteData);

        POSSVS1::create($postulanteData);
        Log::info("Insertado exitosamente: {$postulante->postulante->cedula}");

        return true;
    }

    private function prepareConyugeData($conyuge)
    {
        if (is_null($conyuge) || is_null($conyuge->miembros)) {
            return [
                'cedula' => '',
                'nombre' => '',
                'ingreso' => 0,
                'fecha_nacimiento' => null
            ];
        }

        $miembro = $conyuge->miembros;

        return [
            'cedula' => $miembro->cedula ?? '',
            'nombre' => trim(($miembro->last_name ?? '') . ', ' . ($miembro->first_name ?? '')),
            'ingreso' => $miembro->ingreso ?? 0,
            'fecha_nacimiento' => $miembro->birthdate ?
                date_format(new \DateTime($miembro->birthdate), 'Ymd') : null
        ];
    }

    private function preparePostulanteData($postulante, $key, $requestId, $mesa, $conyugeData, $tipoterreno, $perUser)
    {
        $persona = $postulante->postulante;
        $date = new \DateTime();

        $discapacidadId = optional($persona->discapacidad)->discapacidad_id ?? 1;
        $tieneDiscapacidad = $discapacidadId == 1 ? 'N' : 'S';

        $fechaNacimiento = $persona->birthdate ?
            date_format(new \DateTime($persona->birthdate), 'Ymd') : null;

        $direccion = substr($persona->address ?? '', 0, 60);
        $nombreCompleto = trim($persona->last_name . ', ' . $persona->first_name);

        $ingresoTitular = $persona->ingreso ?? 0;
        $ingresoConyuge = $conyugeData['ingreso'];
        $ingresoFamiliar = $ingresoTitular + $ingresoConyuge;

        return [
            'PsvCod' => $requestId,
            'Psvord' => $key + 1,
            'PsvBibNro' => 0,
            'PsvExpNro' => $mesa->ExpDNro,
            'PsvExpS' => 'A',
            'PsvTDPos' => 'C',
            'PsvTDPosM' => '',
            'PsvCedTit' => $persona->cedula,
            'PsvNomTit' => $nombreCompleto,
            'PsvTDCge' => 'C',
            'PsvTDCgeM' => '',
            'PsvCedCge' => $conyugeData['cedula'],
            'PsvNomCge' => $conyugeData['nombre'],
            'PsvNivel' => 4,
            'PsvCanHij' => $postulante->childrens_count ?? 0,
            'PsvDiscap' => $tieneDiscapacidad,
            'PsvTerEdad' => 'N',
            'PsvSosten' => 'N',
            'PsvAporte' => 0,
            'PsvIfac' => '',
            'PsvDomi' => trim($direccion),
            'PsvObs' => '',
            'PsvRegCon' => 'S',
            'PsvUsuIng' => $perUser,
            'PsvFecIng' => date_format($date, 'Ymd H:i:s'),
            'PsvIngTit' => $ingresoTitular,
            'PsvIngCge' => $ingresoConyuge,
            'PsvIngOtr' => 0,
            'PsvIngFam' => $ingresoFamiliar,
            'PsvNomSos' => '',
            'PsvCgeFNac' => $conyugeData['fecha_nacimiento'],
            'PsvTitFNac' => $fechaNacimiento,
            'PsvTerreno' => trim($tipoterreno->name)
        ];
    }






    public function beneficiarios(ProjectHasPostulante $id)
    {
        //$this->authorize('admin.project-has-expediente.show', $projectHasExpediente);
        //return $id->postulante_id;
        //$postulantes = ProjectHasPostulante::where('project_id', $projectHasExpediente->project_id)->get();
        //return $postulantes;
        // TODO your code goes here
        //5658
        //return $id;
        $members = PostulanteHasBeneficiary::where('postulante_id', $id->postulante_id)->get();
        //return $members;
        return view('admin.project-has-expediente.beneficiarios', compact('id', 'members'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProjectHasExpediente $projectHasExpediente
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ProjectHasExpediente $projectHasExpediente)
    {
        $this->authorize('admin.project-has-expediente.edit', $projectHasExpediente);


        return view('admin.project-has-expediente.edit', [
            'projectHasExpediente' => $projectHasExpediente,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectHasExpediente $request
     * @param ProjectHasExpediente $projectHasExpediente
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateProjectHasExpediente $request, ProjectHasExpediente $projectHasExpediente)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values ProjectHasExpediente
        $projectHasExpediente->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/project-has-expedientes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/project-has-expedientes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyProjectHasExpediente $request
     * @param ProjectHasExpediente $projectHasExpediente
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyProjectHasExpediente $request, ProjectHasExpediente $projectHasExpediente)
    {
        $projectHasExpediente->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyProjectHasExpediente $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyProjectHasExpediente $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    ProjectHasExpediente::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
