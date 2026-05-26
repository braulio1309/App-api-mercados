<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AsignarMercadoRequest;
use App\Http\Requests\StoreVendedorRequest;
use App\Http\Requests\UpdateVendedorRequest;
use App\Http\Resources\VendedorResource;
use App\Models\Vendedor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class VendedorController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $vendedores = Vendedor::with('mercados')->paginate(15);

        return VendedorResource::collection($vendedores);
    }

    public function store(StoreVendedorRequest $request): JsonResponse
    {
        $vendedor = Vendedor::create($request->validated());

        return response()->json([
            'message' => 'Vendedor creado exitosamente.',
            'data'    => new VendedorResource($vendedor),
        ], 201);
    }

    public function show(Vendedor $vendedor): VendedorResource
    {
        $vendedor->load('mercados');

        return new VendedorResource($vendedor);
    }

    public function update(UpdateVendedorRequest $request, Vendedor $vendedor): JsonResponse
    {
        $vendedor->update($request->validated());

        return response()->json([
            'message' => 'Vendedor actualizado exitosamente.',
            'data'    => new VendedorResource($vendedor->load('mercados')),
        ]);
    }

    public function destroy(Vendedor $vendedor): JsonResponse
    {
        $vendedor->delete();

        return response()->json([
            'message' => 'Vendedor eliminado exitosamente.',
        ]);
    }

    public function asignarMercado(AsignarMercadoRequest $request, Vendedor $vendedor): JsonResponse
    {
        $data = $request->validated();

        $vendedor->mercados()->syncWithoutDetaching([
            $data['mercado_id'] => [
                'numero_puesto' => $data['numero_puesto'],
                'dni_vendedor'  => $data['dni_vendedor'] ?? null,
            ],
        ]);

        return response()->json([
            'message' => 'Mercado asignado al vendedor exitosamente.',
            'data'    => new VendedorResource($vendedor->load('mercados')),
        ]);
    }

    public function desasignarMercado(Vendedor $vendedor, int $mercadoId): JsonResponse
    {
        $vendedor->mercados()->detach($mercadoId);

        return response()->json([
            'message' => 'Mercado desasignado del vendedor exitosamente.',
        ]);
    }
}
