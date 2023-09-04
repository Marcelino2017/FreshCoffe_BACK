<?php

namespace App\Http\Controllers;

use App\Http\Resources\PedidoCollection;
use App\Models\Pedido;
use App\Models\PedidoProducto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PedidoCollection(Pedido::with(['user', 'productos'])->where('estado', 0)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Almacenar una orden
        $pedido = new Pedido();
        $pedido->user_id = Auth::user()->id;
        $pedido->total = $request->total;
        $pedido->save();

        //Obtener le ID del pedido
        $id = $pedido->id;

        //Obtener los porductos
        $productos = $request->productos;

        //Formatear un arreglo
        $pedidoProducto = [];

        foreach ($productos as $producto) {
            $pedidoProducto[] = [
                'pedido_id'   => $id,
                'producto_id' => $producto['id'],
                'cantidad'    => $producto['cantidad'],
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ];
        }

        //Almacenar en la DB
        PedidoProducto::insert($pedidoProducto);

        return [
            'message' => 'Pedido realizando correctamente, estará listo en unos minutos'
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pedido $pedido)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        //
    }
}
