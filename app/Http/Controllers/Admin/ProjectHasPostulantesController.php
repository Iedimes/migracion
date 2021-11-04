<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectHasPostulante\BulkDestroyProjectHasPostulante;
use App\Http\Requests\Admin\ProjectHasPostulante\DestroyProjectHasPostulante;
use App\Http\Requests\Admin\ProjectHasPostulante\IndexProjectHasPostulante;
use App\Http\Requests\Admin\ProjectHasPostulante\StoreProjectHasPostulante;
use App\Http\Requests\Admin\ProjectHasPostulante\UpdateProjectHasPostulante;
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

class ProjectHasPostulantesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexProjectHasPostulante $request
     * @return array|Factory|View
     */
    public function index(IndexProjectHasPostulante $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ProjectHasPostulante::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'project_id', 'postulante_id'],

            // set columns to searchIn
            ['id']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.project-has-postulante.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.project-has-postulante.create');

        return view('admin.project-has-postulante.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProjectHasPostulante $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreProjectHasPostulante $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ProjectHasPostulante
        $projectHasPostulante = ProjectHasPostulante::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/project-has-postulantes'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/project-has-postulantes');
    }

    /**
     * Display the specified resource.
     *
     * @param ProjectHasPostulante $projectHasPostulante
     * @throws AuthorizationException
     * @return void
     */
    public function show(ProjectHasPostulante $projectHasPostulante)
    {
        $this->authorize('admin.project-has-postulante.show', $projectHasPostulante);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ProjectHasPostulante $projectHasPostulante
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ProjectHasPostulante $projectHasPostulante)
    {
        $this->authorize('admin.project-has-postulante.edit', $projectHasPostulante);


        return view('admin.project-has-postulante.edit', [
            'projectHasPostulante' => $projectHasPostulante,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProjectHasPostulante $request
     * @param ProjectHasPostulante $projectHasPostulante
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateProjectHasPostulante $request, ProjectHasPostulante $projectHasPostulante)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values ProjectHasPostulante
        $projectHasPostulante->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/project-has-postulantes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/project-has-postulantes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyProjectHasPostulante $request
     * @param ProjectHasPostulante $projectHasPostulante
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyProjectHasPostulante $request, ProjectHasPostulante $projectHasPostulante)
    {
        $projectHasPostulante->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyProjectHasPostulante $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyProjectHasPostulante $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    ProjectHasPostulante::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
