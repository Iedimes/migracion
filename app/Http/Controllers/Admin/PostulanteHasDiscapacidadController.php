<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostulanteHasDiscapacidad\BulkDestroyPostulanteHasDiscapacidad;
use App\Http\Requests\Admin\PostulanteHasDiscapacidad\DestroyPostulanteHasDiscapacidad;
use App\Http\Requests\Admin\PostulanteHasDiscapacidad\IndexPostulanteHasDiscapacidad;
use App\Http\Requests\Admin\PostulanteHasDiscapacidad\StorePostulanteHasDiscapacidad;
use App\Http\Requests\Admin\PostulanteHasDiscapacidad\UpdatePostulanteHasDiscapacidad;
use App\Models\PostulanteHasDiscapacidad;
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

class PostulanteHasDiscapacidadController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPostulanteHasDiscapacidad $request
     * @return array|Factory|View
     */
    public function index(IndexPostulanteHasDiscapacidad $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(PostulanteHasDiscapacidad::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'postulante_id', 'discapacidad_id'],

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

        return view('admin.postulante-has-discapacidad.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.postulante-has-discapacidad.create');

        return view('admin.postulante-has-discapacidad.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostulanteHasDiscapacidad $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePostulanteHasDiscapacidad $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the PostulanteHasDiscapacidad
        $postulanteHasDiscapacidad = PostulanteHasDiscapacidad::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/postulante-has-discapacidads'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/postulante-has-discapacidads');
    }

    /**
     * Display the specified resource.
     *
     * @param PostulanteHasDiscapacidad $postulanteHasDiscapacidad
     * @throws AuthorizationException
     * @return void
     */
    public function show(PostulanteHasDiscapacidad $postulanteHasDiscapacidad)
    {
        $this->authorize('admin.postulante-has-discapacidad.show', $postulanteHasDiscapacidad);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PostulanteHasDiscapacidad $postulanteHasDiscapacidad
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(PostulanteHasDiscapacidad $postulanteHasDiscapacidad)
    {
        $this->authorize('admin.postulante-has-discapacidad.edit', $postulanteHasDiscapacidad);


        return view('admin.postulante-has-discapacidad.edit', [
            'postulanteHasDiscapacidad' => $postulanteHasDiscapacidad,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostulanteHasDiscapacidad $request
     * @param PostulanteHasDiscapacidad $postulanteHasDiscapacidad
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePostulanteHasDiscapacidad $request, PostulanteHasDiscapacidad $postulanteHasDiscapacidad)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values PostulanteHasDiscapacidad
        $postulanteHasDiscapacidad->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/postulante-has-discapacidads'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/postulante-has-discapacidads');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPostulanteHasDiscapacidad $request
     * @param PostulanteHasDiscapacidad $postulanteHasDiscapacidad
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPostulanteHasDiscapacidad $request, PostulanteHasDiscapacidad $postulanteHasDiscapacidad)
    {
        $postulanteHasDiscapacidad->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPostulanteHasDiscapacidad $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPostulanteHasDiscapacidad $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    PostulanteHasDiscapacidad::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
