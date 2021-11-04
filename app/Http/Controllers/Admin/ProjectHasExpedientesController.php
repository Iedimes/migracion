<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectHasExpediente\BulkDestroyProjectHasExpediente;
use App\Http\Requests\Admin\ProjectHasExpediente\DestroyProjectHasExpediente;
use App\Http\Requests\Admin\ProjectHasExpediente\IndexProjectHasExpediente;
use App\Http\Requests\Admin\ProjectHasExpediente\StoreProjectHasExpediente;
use App\Http\Requests\Admin\ProjectHasExpediente\UpdateProjectHasExpediente;
use App\Models\BAMPER;
use App\Models\Postulante;
use App\Models\PostulanteHasBeneficiary;
use App\Models\Project;
use App\Models\ProjectHasExpediente;
use App\Models\ProjectHasPostulante;
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

        //$postulantes = ProjectHasPostulante::where('project_id', $projectHasExpediente)->get();
        //return $postulantes;
        // TODO your code goes here
        return view('admin.project-has-expediente.migracion', compact('project'));
    }

    public function migracionpersonas($projectHasExpediente)
    {

        //$test = BAMPER::where('PerCod', '  931432   ')->get();
        //return $test;

        $postulantes = ProjectHasPostulante::where('project_id', $projectHasExpediente)->get();
        $date = new \DateTime();
        $string = "PINTOS LOMBARDO MARIA FATIMA";

        $data = "123_String";
        $whatIWant = substr($string, strpos($string, " ") + 1);
        //return $whatIWant;
        //return $output = strtok($string,  ' ');
        //return date_format($date, 'Y-m-d H:i:s');
        //$nac = new \DateTime('1985-02-09');

        /*$nac = "2021-11-03 13:39:23";
        $fecNac = new \DateTime($nac);
        return $fecNac;*/
        //return $postulantes;

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
                    'PerDomic' => mb_convert_encoding($value->postulante->address, 'Windows-1252', 'UTF-8'),
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
                    'PerFUM' => date_format($date, 'Y-m-d H:i:s'),
                    'PerUser' => 'PACOSTA'
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
                            'PerDomic' => mb_convert_encoding($member->miembros->address, 'Windows-1252', 'UTF-8'),
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
                            'PerFUM' => date_format($date, 'Y-m-d H:i:s'),
                            'PerUser' => 'PACOSTA'
                        ]);
                        //$nac = new \DateTime();
                    }
                }
            }
        }
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
