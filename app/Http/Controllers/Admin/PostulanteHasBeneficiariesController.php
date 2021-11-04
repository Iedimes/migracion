<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostulanteHasBeneficiary\BulkDestroyPostulanteHasBeneficiary;
use App\Http\Requests\Admin\PostulanteHasBeneficiary\DestroyPostulanteHasBeneficiary;
use App\Http\Requests\Admin\PostulanteHasBeneficiary\IndexPostulanteHasBeneficiary;
use App\Http\Requests\Admin\PostulanteHasBeneficiary\StorePostulanteHasBeneficiary;
use App\Http\Requests\Admin\PostulanteHasBeneficiary\UpdatePostulanteHasBeneficiary;
use App\Models\PostulanteHasBeneficiary;
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

class PostulanteHasBeneficiariesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPostulanteHasBeneficiary $request
     * @return array|Factory|View
     */
    public function index(IndexPostulanteHasBeneficiary $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(PostulanteHasBeneficiary::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'postulante_id', 'miembro_id', 'parentesco_id'],

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

        return view('admin.postulante-has-beneficiary.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.postulante-has-beneficiary.create');

        return view('admin.postulante-has-beneficiary.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostulanteHasBeneficiary $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePostulanteHasBeneficiary $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the PostulanteHasBeneficiary
        $postulanteHasBeneficiary = PostulanteHasBeneficiary::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/postulante-has-beneficiaries'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/postulante-has-beneficiaries');
    }

    /**
     * Display the specified resource.
     *
     * @param PostulanteHasBeneficiary $postulanteHasBeneficiary
     * @throws AuthorizationException
     * @return void
     */
    public function show(PostulanteHasBeneficiary $postulanteHasBeneficiary)
    {
        $this->authorize('admin.postulante-has-beneficiary.show', $postulanteHasBeneficiary);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PostulanteHasBeneficiary $postulanteHasBeneficiary
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(PostulanteHasBeneficiary $postulanteHasBeneficiary)
    {
        $this->authorize('admin.postulante-has-beneficiary.edit', $postulanteHasBeneficiary);


        return view('admin.postulante-has-beneficiary.edit', [
            'postulanteHasBeneficiary' => $postulanteHasBeneficiary,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePostulanteHasBeneficiary $request
     * @param PostulanteHasBeneficiary $postulanteHasBeneficiary
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePostulanteHasBeneficiary $request, PostulanteHasBeneficiary $postulanteHasBeneficiary)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values PostulanteHasBeneficiary
        $postulanteHasBeneficiary->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/postulante-has-beneficiaries'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/postulante-has-beneficiaries');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPostulanteHasBeneficiary $request
     * @param PostulanteHasBeneficiary $postulanteHasBeneficiary
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPostulanteHasBeneficiary $request, PostulanteHasBeneficiary $postulanteHasBeneficiary)
    {
        $postulanteHasBeneficiary->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPostulanteHasBeneficiary $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPostulanteHasBeneficiary $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    PostulanteHasBeneficiary::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
