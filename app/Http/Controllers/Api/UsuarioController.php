<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Http\Resources\UsuarioResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UsuarioController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $usuarios = User::paginate(15);

        return UsuarioResource::collection($usuarios);
    }

    public function store(StoreUsuarioRequest $request): JsonResponse
    {
        $usuario = User::create($request->validated());

        return response()->json([
            'message' => 'Usuario creado exitosamente.',
            'data'    => new UsuarioResource($usuario),
        ], 201);
    }

    public function show(User $usuario): UsuarioResource
    {
        return new UsuarioResource($usuario);
    }

    public function update(UpdateUsuarioRequest $request, User $usuario): JsonResponse
    {
        $usuario->update($request->validated());

        return response()->json([
            'message' => 'Usuario actualizado exitosamente.',
            'data'    => new UsuarioResource($usuario),
        ]);
    }

    public function destroy(User $usuario): JsonResponse
    {
        $usuario->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente.',
        ]);
    }
}
