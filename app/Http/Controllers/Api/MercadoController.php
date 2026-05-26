<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMercadoRequest;
use App\Http\Requests\UpdateMercadoRequest;
use App\Http\Resources\MercadoResource;
use App\Models\Mercado;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MercadoController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $mercados = Mercado::with('vendedores')->paginate(15);

        return MercadoResource::collection($mercados);
    }

    public function store(StoreMercadoRequest $request): JsonResponse
    {
        $mercado = Mercado::create($request->validated());

        return response()->json([
            'message' => 'Mercado creado exitosamente.',
            'data'    => new MercadoResource($mercado),
        ], 201);
    }

    public function show(Mercado $mercado): MercadoResource
    {
        $mercado->load('vendedores');

        return new MercadoResource($mercado);
    }

    public function update(UpdateMercadoRequest $request, Mercado $mercado): JsonResponse
    {
        $mercado->update($request->validated());

        return response()->json([
            'message' => 'Mercado actualizado exitosamente.',
            'data'    => new MercadoResource($mercado->load('vendedores')),
        ]);
    }

    public function destroy(Mercado $mercado): JsonResponse
    {
        $mercado->delete();

        return response()->json([
            'message' => 'Mercado eliminado exitosamente.',
        ]);
    }
}
