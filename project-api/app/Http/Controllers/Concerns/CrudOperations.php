<?php

namespace App\Http\Controllers\Concerns;

use App\Helpers\ResponseHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

trait CrudOperations
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $with = $request->query('with', $this->with);
        $withArray = $with ? (is_array($with) ? $with : explode(',', $with)) : null;

        $modelInstance = new $this->model();

        $data = $this->fetchAll($modelInstance, $withArray);

        return ResponseHelper::success($data, 'Resources retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate($this->rules());
        $modelInstance = (new $this->model())->create($validatedData);

        return ResponseHelper::success($modelInstance, 'Resource created successfully', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function show(Request $request, $id): JsonResponse
    {
        $with = $request->query('with', $this->with);
        $withArray = $with ? (is_array($with) ? $with : explode(',', $with)) : null;

        $query = (new $this->model())->newQuery();

        if ($withArray) {
            $query->with($withArray);
        }

        $modelInstance = $query->find($id);

        if (! $modelInstance) {
            return ResponseHelper::error('Resource not found', 404);
        }

        return ResponseHelper::success($modelInstance, 'Resource retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate($this->rules());
        $modelInstance = (new $this->model())->findOrFail($id);
        $modelInstance->update($validatedData);

        return ResponseHelper::success($modelInstance, 'Resource updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $modelInstance = (new $this->model())->findOrFail($id);
        $modelInstance->delete();

        return ResponseHelper::success(null, 'Resource deleted successfully', 204);
    }
}
