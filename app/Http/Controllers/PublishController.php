<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PublishController extends Controller
{
    public function toggle(Request $request, string $model, int $id)
    {
        $instance = $this->resolveModel($model, $id);

        $column = $request->get('column', 'is_published');

        if (!isset($instance->{$column})) {
            abort(400, "Publish column '{$column}' does not exist.");
        }

        $instance->update([
            $column => !(bool) $instance->{$column},
        ]);

        return $this->redirectToIndex($model)
            ->with('success', 'Publish status updated successfully.');
    }

    protected function resolveModel(string $model, int $id)
    {
        $class = 'App\\Models\\' . Str::studly($model);

        if (!class_exists($class)) {
            throw new NotFoundHttpException("Model '{$model}' not found.");
        }

        return $class::findOrFail($id);
    }

    protected function redirectToIndex(string $model)
    {
        $route = "{$model}.index";

        return Route::has($route)
            ? redirect()->route($route)
            : redirect()->back();
    }
}