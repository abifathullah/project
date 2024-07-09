<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\CrudOperations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, CrudOperations;

    /**
     * The class name of the model.
     *
     * @var string|null
     */
    protected $model;

    /**
     * Relationships to eager load.
     *
     * @var string[]|null
     */
    protected $with;

    /**
     * Constructor to set default model and eager loading relationships.
     */
    public function __construct()
    {
        $this->model = $this->getModelClass();
        $this->with = $this->getWith();
    }

    /**
     * Retrieve the class name of the model.
     *
     * @return string
     */
    protected function getModelClass(): string
    {
        // Derive model class based on convention
        $className = class_basename($this);
        $modelName = Str::replaceLast('Controller', '', $className);
        $modelNamespace = 'App\Models\\';

        return $modelNamespace . $modelName;
    }

    /**
     * Retrieve the relationships to eager load.
     *
     * @return string[]|null
     */
    protected function getWith(): ?array
    {
        // Default to null (no eager loading)
        return null;
    }

    /**
     * Retrieve all instances of the given model.
     *
     * @param  Model  $model
     * @param  string[]|null  $with
     * @return JsonResponse
     */
    protected function fetchAll(Model $model, ?array $with = null): JsonResponse
    {
        $query = $model::query();

        if ($with) {
            $query->with($with);
        }

        $instances = $query->get();

        return response()->json($instances, 200);
    }

    /**
     * Define the validation rules for the model.
     *
     * @return array<string>
     */
    protected function rules(): array
    {
        return [];
    }
}
