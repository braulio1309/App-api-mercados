<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRepartidorRequest;
use App\Http\Requests\UpdateRepartidorRequest;
use App\Http\Resources\RepartidorResource;
use App\Models\Repartidor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RepartidorController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $repartidores = Repartidor::paginate(15);

        return RepartidorResource::collection($repartidores);
    }

    public function store(StoreRepartidorRequest $request): JsonResponse
    {
        $repartidor = Repartidor::create($request->validated());

        return response()->json([
            'message' => 'Repartidor creado exitosamente.',
            'data'    => new RepartidorResource($repartidor),
        ], 201);
    }

    public function show(Repartidor $repartidor): RepartidorResource
    {
        return new RepartidorResource($repartidor);
    }

    public function update(UpdateRepartidorRequest $request, Repartidor $repartidor): JsonResponse
    {
        $repartidor->update($request->validated());

        return response()->json([
            'message' => 'Repartidor actualizado exitosamente.',
            'data'    => new RepartidorResource($repartidor),
        ]);
    }

    public function destroy(Repartidor $repartidor): JsonResponse
    {
        $repartidor->delete();

        return response()->json([
            'message' => 'Repartidor eliminado exitosamente.',
        ]);
    }
}
