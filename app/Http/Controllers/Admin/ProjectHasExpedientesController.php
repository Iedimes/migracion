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
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'project_id', 'exp'],

            // set columns to searchIn
            ['id', 'exp']
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

        $postulantes = ProjectHasPostulante::where('project_id', $projectHasExpediente->project_id)->get();
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
        $postulantes = ProjectHasPostulante::where('project_id', $projectHasExpediente)->get();
        $date = new \DateTime();
        $estciv = array(
            'SO' => 1,
            'CA' => 2,
            'VI' => 6,
            'ME' => 1,
        );

        $relpar = array(
            'SO' => 1,
            'CA' => 2,
            'VI' => 1,
            'ME' => 1,
        );

        //return $estciv['VI'];

        foreach ($postulantes as $key => $value) {

            $user = BAMPER::where('PerCod',  $value->postulante->cedula)->first();
            $email = Auth::user()->email;
            //return mb_convert_encoding($user->PerNom, 'Windows-1252', 'UTF-8');
            $nombre = $value->postulante->last_name . ' ' . $value->postulante->first_name;
            $nac = new \DateTime($value->postulante->birthdate);
            $f = date_format($nac, 'Ymd');
            //Controlo si tiene espacios para segundo nombre
            if (str_contains($value->postulante->first_name, ' ')) {
                $nomsegpos = substr($value->postulante->first_name, strpos($value->postulante->first_name, " ") + 1);
            } else {
                $nomsegpos = "";
            }

            if (str_contains($value->postulante->last_name, ' ')) {
                $apesegpos = substr($value->postulante->last_name, strpos($value->postulante->last_name, " ") + 1);
            } else {
                $apesegpos = "";
            }

            $apepripos = strtok($value->postulante->last_name,  ' ');
            $nompripos = strtok($value->postulante->first_name,  ' ');


            //$date = new \DateTime();

            if (!$user) {
                $reg = BAMPER::create([
                    'PerCod' => $value->postulante->cedula,
                    'PerNom' => mb_convert_encoding($nombre, 'Windows-1252', 'UTF-8'),
                    'PerApePri' => mb_convert_encoding($apepripos, 'Windows-1252', 'UTF-8'),
                    'PerNomPri' => mb_convert_encoding($nompripos, 'Windows-1252', 'UTF-8'),
                    'PerApeSeg' => mb_convert_encoding($apesegpos, 'Windows-1252', 'UTF-8'),
                    'PerNomSeg' => mb_convert_encoding($nomsegpos, 'Windows-1252', 'UTF-8'),
                    'PerDomic' => mb_convert_encoding(substr($value->postulante->address, 0, 60), 'Windows-1252', 'UTF-8'),
                    'PerTel1' => $value->postulante->phone,
                    'PerTel2' => $value->postulante->mobile,
                    'PerEstCiv' => $estciv[$value->postulante->marital_status],
                    'PerTpDoc' => 'CID',
                    'PerFchNac' => $f,
                    'PerSexo' => $value->postulante->gender,
                    'ProCod' => 58,
                    'ActCod' => 7,
                    'PerNac' => 1,
                    'DptoId' => 11,
                    'CiuId' => 179,
                    'PerRelPar' => $relpar[$value->postulante->marital_status],
                    //'PerEstCiv' => 1,
                    'PerFUM' => date_format($date, 'Ymd H:i:s'),
                    'PerUser' => strtoupper(substr(strstr($email, '@', true), 0, 10))
                ]);
            }




            if (count($value->members) > 0) {
                //return "No vacio";
                foreach ($value->members as $member) {

                    $miembro = BAMPER::where('PerCod', $member->miembros->cedula)->first();
                    if (!$miembro) {
                        $nombremiembro = $member->miembros->last_name . ' ' . $member->miembros->first_name;
                        $nac = new \DateTime($member->miembros->birthdate);
                        $apepri = strtok($member->miembros->last_name,  ' ');
                        $nompri = strtok($member->miembros->first_name,  ' ');

                        if (str_contains($member->miembros->first_name, ' ')) {
                            $nomseg = substr($member->miembros->first_name, strpos($member->miembros->first_name, " ") + 1);
                        } else {
                            $nomseg = "";
                        }

                        if (str_contains($member->miembros->last_name, ' ')) {
                            $apeseg = substr($member->miembros->last_name, strpos($member->miembros->last_name, " ") + 1);
                        } else {
                            $apeseg = "";
                        }
                        $reg = BAMPER::create([
                            'PerCod' => $member->miembros->cedula,
                            'PerNom' => mb_convert_encoding($nombremiembro, 'Windows-1252', 'UTF-8'),
                            'PerApePri' => mb_convert_encoding($apepri, 'Windows-1252', 'UTF-8'),
                            'PerNomPri' => mb_convert_encoding($nompri, 'Windows-1252', 'UTF-8'),
                            'PerApeSeg' => mb_convert_encoding($apeseg, 'Windows-1252', 'UTF-8'),
                            'PerNomSeg' => mb_convert_encoding($nomseg, 'Windows-1252', 'UTF-8'),
                            'PerEstCiv' => $estciv[$member->miembros->marital_status],
                            'PerDomic' => mb_convert_encoding(substr($member->miembros->address, 0, 60), 'Windows-1252', 'UTF-8'),
                            'PerTel1' => $member->miembros->phone,
                            'PerTel2' => $member->miembros->mobile,
                            'PerTpDoc' => 'CID',
                            'ProCod' => 58,
                            'PerFchNac' => date_format($nac, 'Ymd'),
                            'PerSexo' => $member->miembros->gender,
                            'ActCod' => 7,
                            'PerNac' => 1,
                            'DptoId' => 11,
                            'CiuId' => 179,
                            'PerRelPar' => $relpar[$member->miembros->marital_status],
                            'PerFUM' => date_format($date, 'Ymd H:i:s'),
                            'PerUser' => strtoupper(substr(strstr($email, '@', true), 0, 10))
                        ]);
                        //$nac = new \DateTime();
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Datos Migrados Correctamente!');
    }

    public function migracionshd($projectHasExpediente, Request $request)
    {

        $reg = POSSVS::where('PsvCod', $request->id)->first();
        $exp = ProjectHasExpediente::where('project_id', $projectHasExpediente)->first();
        $date = new \DateTime();
        $email = Auth::user()->email;
        //return strstr($email, '@', true);
        if ($reg) {
            # code...
            $postulantes = ProjectHasPostulante::where('project_id', $projectHasExpediente)->get();
            //return $reg;

            foreach ($postulantes as $key => $value) {
                $user = POSSVS1::where('PsvCedTit',  $value->postulante->cedula)
                    ->where('PsvCod', $request->id)
                    ->first();
                $nombre = $value->postulante->last_name . ', ' . $value->postulante->first_name;
                $mesa = SIG005L1::where('ExpDPerCod',  $value->postulante->cedula)
                    ->where('NroExp', $exp->exp)
                    ->first();
                if (is_null($value->conyuge)) {
                    $solpercge = "";
                    $conyuname = "";
                    $ingconyuge = 0;
                    $c = null;
                } else {
                    $solpercge = $value->conyuge->miembros->cedula;
                    $conyuname = $value->conyuge->miembros->last_name . ", " . $value->conyuge->miembros->first_name;
                    $ingconyuge = $value->conyuge->miembros->ingreso;
                    $con = new \DateTime($value->conyuge->miembros->birthdate);
                    $c = date_format($con, 'Ymd');
                }

                if ($value->postulante->discapacidad->discapacidad_id == 1) {
                    $dis = 'N';
                } else {
                    $dis = 'S';
                }

                $nac = new \DateTime($value->postulante->birthdate);
                $f = date_format($nac, 'Ymd');


                if (!$user) {

                    $reg = POSSVS1::create([
                        'PsvCod' => $request->id,
                        'Psvord' => $key + 1,
                        'PsvBibNro' => 0,
                        'PsvExpNro' => $mesa->ExpDNro,
                        'PsvExpS' => 'A',
                        'PsvTDPos' => 'C',
                        'PsvTDPosM' => '',
                        'PsvCedTit' => $value->postulante->cedula,
                        'PsvNomTit' => mb_convert_encoding($nombre, 'Windows-1252', 'UTF-8'),
                        'PsvTDCge' => 'C',
                        'PsvTDCgeM' => '',
                        'PsvCedCge' => $solpercge,
                        'PsvNomCge' => mb_convert_encoding($conyuname, 'Windows-1252', 'UTF-8'),
                        'PsvNivel' => 4,
                        'PsvCanHij' => $value->childrens_count,
                        'PsvDiscap' => $dis,
                        'PsvTerEdad' => 'N',
                        'PsvSosten' => 'N',
                        'PsvAporte' => 0, //$value->postulante->ingreso,
                        'PsvIfac' => '',
                        'PsvDomi' => mb_convert_encoding(substr($value->postulante->address, 0, 60), 'Windows-1252', 'UTF-8'),
                        'PsvObs' => '',
                        'PsvRegCon' => 'S',
                        'PsvUsuIng' => strtoupper(substr(strstr($email, '@', true), 0, 10)),
                        'PsvFecIng' => date_format($date, 'Ymd H:i:s'),
                        'PsvIngTit' => $value->postulante->ingreso,
                        'PsvIngCge' => $ingconyuge,
                        'PsvIngOtr' => 0,
                        'PsvIngFam' => $value->postulante->ingreso + $ingconyuge,
                        'PsvNomSos' => '',
                        'PsvCgeFNac' => $c,
                        'PsvTitFNac' => $f

                    ]);
                }
            }

            return redirect()->back()->with('success', 'Datos Migrados Correctamente!');
        } else {
            return redirect()->back()->with('error', 'No se encontro planilla SHD!');
        }

        //return $request->id;
    }

    public function migracionsolicitantes($projectHasExpediente)
    {

        //return "migracio solicitantes";
        $postulantes = ProjectHasPostulante::where('project_id', $projectHasExpediente)->get();
        //return $postulantes;
        $exp = ProjectHasExpediente::where('project_id', $projectHasExpediente)->first();
        //return $exp->project_id;
        $date = new \DateTime();
        $email = Auth::user()->email;

        $parent = array(
            1 => 1,
            2 => 3,
            3 => 2,
            4 => 4,
            7 => 9,
            8 => 1,
            9 => 5,
            10 => 6,
            11 => 5,
            14 => 10,
        );

        foreach ($postulantes as $key => $value) {

            $user = IVMSOL::where('SolPerCod',  $value->postulante->cedula)->first();
            $mesa = SIG005L1::where('ExpDPerCod',  $value->postulante->cedula)
                ->where('NroExp', $exp->exp)
                ->first();
            $expfec =
                $nac = new \DateTime($mesa->ExpDFec);
            if (is_null($value->conyuge)) {
                $solpercge = "";
            } else {
                $solpercge = $value->conyuge->miembros->cedula;
            }

            if (!$user) {

                $reg = IVMSOL::create([
                    'SolPerCod' => $value->postulante->cedula,
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
                    'SolInscri' => strtoupper(substr(strstr($email, '@', true), 0, 10)),
                    'SolComent' => '',
                    'SolPerCge' => $solpercge,
                    'SolHabViv' => '',
                    'SolFum' => date_format($date, 'Ymd H:i:s'),
                    'SolEtapa' => 'S',
                    'SolReFecAd' => null,
                    'SolReNroAd' => null,
                    'SolCodObra' => null,
                    'SolComent' => "Exp. Social: " . $exp->exp . " Codigo de Proyecto: " . $exp->project_id,

                ]);
            }

            $pos = BAMPER::where('PerCod', $value->postulante->cedula)->first();
            $posivms = IVMSOL2::where('GfsCod', $value->postulante->cedula)->first();
            //return $pos;
            $datecalc = new \DateTime($pos->PerFchNac);
            $now = new \DateTime($mesa->ExpDFec);
            $interval = $now->diff($datecalc);
            if ($value->postulante->discapacidad->discapacidad_id == 1) {
                $dis = 'N';
            } else {
                $dis = 'S';
            }

            if (!$posivms) {
                $reg = IVMSOL2::create([
                    'SolPerCod' => $value->postulante->cedula,
                    'GfsCod' => $value->postulante->cedula,
                    'GfsEdad' => $interval->y,
                    'ParCod' => 8,
                    'GfsDis' => $dis,
                    'GfsImpSue' => $value->postulante->ingreso,
                    'GfsImpApo' => 0,
                    'GfsUsuCod' => strtoupper(substr(strstr($email, '@', true), 0, 10)),
                    'GfsFecAlta' => date_format($date, 'Ymd H:i:s')

                ]);
            }

            if (count($value->members) > 0) {
                //return "No vacio";
                foreach ($value->members as $member) {

                    $miembro = IVMSOL2::where('GfsCod', $member->miembros->cedula)->first();
                    if (!$miembro) {
                        $pos = BAMPER::where('PerCod', $member->miembros->cedula)->first();
                        //$posivms = IVMSOL2::where('GfsCod', $member->postulante->cedula)->first();
                        //return $pos;
                        $datecalmember = new \DateTime($pos->PerFchNac);
                        $now = new \DateTime($mesa->ExpDFec);
                        $interval = $now->diff($datecalmember);
                        if ($member->miembros->discapacidad->discapacidad_id == 1) {
                            $dis = 'N';
                        } else {
                            $dis = 'S';
                        }
                        $reg = IVMSOL2::create([
                            'SolPerCod' => $value->postulante->cedula,
                            'GfsCod' => $member->miembros->cedula,
                            'GfsEdad' => $interval->y,
                            'ParCod' =>  $parent[$member->parentesco->id],
                            'GfsDis' => $dis,
                            'GfsImpSue' => $member->miembros->ingreso,
                            'GfsImpApo' => 0,
                            'GfsUsuCod' => strtoupper(substr(strstr($email, '@', true), 0, 10)),
                            'GfsFecAlta' => date_format($date, 'Ymd H:i:s')

                        ]);
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Datos Migrados Correctamente!');
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
