<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Postulante\BulkDestroyPostulante;
use App\Http\Requests\Admin\Postulante\DestroyPostulante;
use App\Http\Requests\Admin\Postulante\IndexPostulante;
use App\Http\Requests\Admin\Postulante\StorePostulante;
use App\Http\Requests\Admin\Postulante\UpdatePostulante;
use App\Models\Postulante;
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

class PostulantesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPostulante $request
     * @return array|Factory|View
     */
    public function index(IndexPostulante $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Postulante::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'first_name', 'last_name', 'cedula', 'marital_status', 'nacionalidad', 'gender', 'birthdate', 'localidad', 'asentamiento', 'ingreso', 'address', 'grupo', 'phone', 'mobile', 'nexp'],

            // set columns to searchIn
            ['id', 'first_name', 'last_name', 'cedula', 'marital_status', 'nacionalidad', 'gender', 'birthdate', 'localidad', 'asentamiento', 'address', 'grupo', 'phone', 'mobile', 'nexp']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.postulante.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.postulante.create');

        return view('admin.postulante.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostulante $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePostulante $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Postulante
        $postulante = Postulante::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/postulantes'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/postulantes');
    }

    /**
     * Display the specified resource.
     *
     * @param Postulante $postulante
     * @throws AuthorizationException
     * @return void
     */
    public function show(Postulante $postulante)
    {
        $this->authorize('admin.postulante.show', $postulante);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Postulante $postulante
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Postulante $postulante)
    {
        $this->authorize('admin.postulante.edit', $postulante);


        return view('admin.postulante.edit', [
            'postulante' => $postulante,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostulante $request
     * @param Postulante $postulante
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePostulante $request, Postulante $postulante)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Postulante
        $postulante->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/postulantes'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/postulantes');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPostulante $request
     * @param Postulante $postulante
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPostulante $request, Postulante $postulante)
    {
        $postulante->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPostulante $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPostulante $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Postulante::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
