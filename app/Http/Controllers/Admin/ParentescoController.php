<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Parentesco\BulkDestroyParentesco;
use App\Http\Requests\Admin\Parentesco\DestroyParentesco;
use App\Http\Requests\Admin\Parentesco\IndexParentesco;
use App\Http\Requests\Admin\Parentesco\StoreParentesco;
use App\Http\Requests\Admin\Parentesco\UpdateParentesco;
use App\Models\Parentesco;
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

class ParentescoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexParentesco $request
     * @return array|Factory|View
     */
    public function index(IndexParentesco $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Parentesco::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name'],

            // set columns to searchIn
            ['id', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.parentesco.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.parentesco.create');

        return view('admin.parentesco.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreParentesco $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreParentesco $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Parentesco
        $parentesco = Parentesco::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/parentescos'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/parentescos');
    }

    /**
     * Display the specified resource.
     *
     * @param Parentesco $parentesco
     * @throws AuthorizationException
     * @return void
     */
    public function show(Parentesco $parentesco)
    {
        $this->authorize('admin.parentesco.show', $parentesco);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Parentesco $parentesco
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Parentesco $parentesco)
    {
        $this->authorize('admin.parentesco.edit', $parentesco);


        return view('admin.parentesco.edit', [
            'parentesco' => $parentesco,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateParentesco $request
     * @param Parentesco $parentesco
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateParentesco $request, Parentesco $parentesco)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Parentesco
        $parentesco->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/parentescos'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/parentescos');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyParentesco $request
     * @param Parentesco $parentesco
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyParentesco $request, Parentesco $parentesco)
    {
        $parentesco->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyParentesco $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyParentesco $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Parentesco::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
