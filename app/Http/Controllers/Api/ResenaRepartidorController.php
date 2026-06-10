<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResenaRepartidorRequest;
use App\Http\Requests\UpdateResenaRepartidorRequest;
use App\Http\Resources\ResenaRepartidorResource;
use App\Models\Repartidor;
use App\Models\ResenaRepartidor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ResenaRepartidorController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $resenas = ResenaRepartidor::with(['repartidor', 'usuario'])
            ->latest()
            ->paginate(15);

        return ResenaRepartidorResource::collection($resenas);
    }

    public function porRepartidor(Repartidor $repartidor): AnonymousResourceCollection
    {
        $resenas = $repartidor->resenas()
            ->with(['usuario'])
            ->latest()
            ->paginate(15);

        return ResenaRepartidorResource::collection($resenas);
    }

    public function store(StoreResenaRepartidorRequest $request): JsonResponse
    {
        $resena = ResenaRepartidor::create($request->validated());

        return response()->json([
            'message' => 'Reseña creada exitosamente.',
            'data'    => new ResenaRepartidorResource($resena->load(['repartidor', 'usuario'])),
        ], 201);
    }

    public function show(ResenaRepartidor $resenaRepartidor): ResenaRepartidorResource
    {
        $resenaRepartidor->load(['repartidor', 'usuario']);

        return new ResenaRepartidorResource($resenaRepartidor);
    }

    public function update(UpdateResenaRepartidorRequest $request, ResenaRepartidor $resenaRepartidor): JsonResponse
    {
        $resenaRepartidor->update($request->validated());

        return response()->json([
            'message' => 'Reseña actualizada exitosamente.',
            'data'    => new ResenaRepartidorResource($resenaRepartidor->load(['repartidor', 'usuario'])),
        ]);
    }

    public function destroy(ResenaRepartidor $resenaRepartidor): JsonResponse
    {
        $resenaRepartidor->delete();

        return response()->json([
            'message' => 'Reseña eliminada exitosamente.',
        ]);
    }
}
