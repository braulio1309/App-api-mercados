<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RepartidorResource;
use App\Http\Resources\UsuarioResource;
use App\Http\Resources\VendedorResource;
use App\Models\Repartidor;
use App\Models\User;
use App\Models\Vendedor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login para usuarios, repartidores o vendedores.
     * El campo "tipo" define el tipo de entidad: usuario | repartidor | vendedor
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
            'tipo'     => ['required', 'in:usuario,repartidor,vendedor'],
        ]);

        [$model, $resource, $tokenName] = match ($request->tipo) {
            'repartidor' => [Repartidor::class, RepartidorResource::class, 'repartidor-token'],
            'vendedor'   => [Vendedor::class, VendedorResource::class, 'vendedor-token'],
            default      => [User::class, UsuarioResource::class, 'usuario-token'],
        };

        /** @var \Illuminate\Foundation\Auth\User|null $entidad */
        $entidad = $model::where('email', $request->email)->first();

        if (! $entidad || ! Hash::check($request->password, $entidad->password)) {
            throw ValidationException::withMessages([
                'email' => ['Las credenciales proporcionadas son incorrectas.'],
            ]);
        }

        $token = $entidad->createToken($tokenName)->plainTextToken;

        return response()->json([
            'message' => 'Inicio de sesión exitoso.',
            'tipo'    => $request->tipo,
            'token'   => $token,
            'data'    => new $resource($entidad),
        ]);
    }

    /**
     * Cerrar sesión revocando el token actual.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Sesión cerrada exitosamente.',
        ]);
    }

    /**
     * Retorna los datos del usuario autenticado.
     */
    public function me(Request $request): JsonResponse
    {
        $entidad = $request->user();

        $resource = match (true) {
            $entidad instanceof Repartidor => new RepartidorResource($entidad),
            $entidad instanceof Vendedor   => new VendedorResource($entidad),
            default                        => new UsuarioResource($entidad),
        };

        return response()->json(['data' => $resource]);
    }
}
