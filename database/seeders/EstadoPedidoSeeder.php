<?php

namespace Database\Seeders;

use App\Models\EstadoPedido;
use Illuminate\Database\Seeder;

class EstadoPedidoSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['nombre' => 'Pendiente',           'descripcion' => 'El pedido fue recibido y espera confirmacion.',            'color' => '#FFA500', 'orden' => 1],
            ['nombre' => 'Confirmado',           'descripcion' => 'El pedido fue confirmado por el vendedor.',                'color' => '#2196F3', 'orden' => 2],
            ['nombre' => 'En preparacion',       'descripcion' => 'El vendedor esta preparando el pedido.',                  'color' => '#9C27B0', 'orden' => 3],
            ['nombre' => 'Listo en el negocio',  'descripcion' => 'El pedido esta listo y esperando ser recogido.',          'color' => '#FF9800', 'orden' => 4],
            ['nombre' => 'En camino',            'descripcion' => 'El repartidor recogio el pedido y va en camino.',         'color' => '#03A9F4', 'orden' => 5],
            ['nombre' => 'Entregado',            'descripcion' => 'El pedido fue entregado al cliente satisfactoriamente.',  'color' => '#4CAF50', 'orden' => 6],
            ['nombre' => 'Cancelado',            'descripcion' => 'El pedido fue cancelado.',                                'color' => '#F44336', 'orden' => 7],
        ];

        foreach ($estados as $estado) {
            EstadoPedido::firstOrCreate(['nombre' => $estado['nombre']], $estado);
        }
    }
}
