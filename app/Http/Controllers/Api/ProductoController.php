<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Http\Resources\ProductoResource;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductoController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $productos = Producto::with(['categoria', 'mercado'])->paginate(15);

        return ProductoResource::collection($productos);
    }

    public function store(StoreProductoRequest $request): JsonResponse
    {
        $producto = Producto::create($request->validated());

        return response()->json([
            'message' => 'Producto creado exitosamente.',
            'data'    => new ProductoResource($producto->load(['categoria', 'mercado'])),
        ], 201);
    }

    public function show(Producto $producto): ProductoResource
    {
        $producto->load(['categoria', 'mercado']);

        return new ProductoResource($producto);
    }

    public function update(UpdateProductoRequest $request, Producto $producto): JsonResponse
    {
        $producto->update($request->validated());

        return response()->json([
            'message' => 'Producto actualizado exitosamente.',
            'data'    => new ProductoResource($producto->load(['categoria', 'mercado'])),
        ]);
    }

    public function destroy(Producto $producto): JsonResponse
    {
        $producto->delete();

        return response()->json([
            'message' => 'Producto eliminado exitosamente.',
        ]);
    }
}
