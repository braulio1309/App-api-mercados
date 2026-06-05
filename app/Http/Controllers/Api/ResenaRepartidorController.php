<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreResenaRepartidorRequest;
use App\Http\Resources\ResenaRepartidorResource;
use App\Models\ResenaRepartidor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ResenaRepartidorController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $resenas = ResenaRepartidor::with(['usuario', 'repartidor'])
            ->latest()
            ->paginate(15);

        return ResenaRepartidorResource::collection($resenas);
    }

    public function store(StoreResenaRepartidorRequest $request): JsonResponse
    {
        $resena = ResenaRepartidor::create($request->validated());

        return response()->json([
            'message' => 'Reseña creada exitosamente.',
            'data'    => new ResenaRepartidorResource(
                $resena->load(['usuario', 'repartidor'])
            ),
        ], 201);
    }

    public function show(ResenaRepartidor $resenaRepartidor): ResenaRepartidorResource
    {
        $resenaRepartidor->load(['usuario', 'repartidor']);

        return new ResenaRepartidorResource($resenaRepartidor);
    }

    public function destroy(ResenaRepartidor $resenaRepartidor): JsonResponse
    {
        $resenaRepartidor->delete();

        return response()->json([
            'message' => 'Reseña eliminada exitosamente.',
        ]);
    }
}
