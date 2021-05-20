<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function store(Request $request)
    {
        try {
            $nuevoPedido = new Order();
            $nuevoPedido->user_id = $request->user_id;
            $nuevoPedido->deliveryAddress = $request->deliveryAddress;
            $nuevoPedido->totalPrice = $request->totalPrice;
            $nuevoPedido->save();

            $pedidos = Order::get();

            foreach ($pedidos as $idPedido) {
                $ultimoIdPedido = $idPedido->id;
            }


            foreach ($request->lineaPedido as $req) {
                $producto = Product::find($req["product_id"]);
                $producto->stock = ($producto->stock - $req["quantity"]);
                $producto->save();             
                $nuevaLineaPedido = new OrderLine();
                $nuevaLineaPedido->order_id = $ultimoIdPedido;
                $nuevaLineaPedido->product_id = $req["product_id"];
                $nuevaLineaPedido->quantity = $req["quantity"];
                $nuevaLineaPedido->price = $req["price"];
                $nuevaLineaPedido->save();
            }

            \Cart::session(auth()->id())->clear();

            return back()->with('success', '¡La compra se ha realizado correctamente!');
        } catch (\Throwable $th) {
            abort(403, 'Bad Request');
        }
    }
    public function pedidos()
    {
        $pedidos = Order::paginate(12);
        return view('usuarios.pedidos.listOrder', compact('pedidos'));
    }
    public function destroy(Order $pedido)
    {
        try {
            $pedido->delete();
            return back()->with('success', '¡El pedido "' . $pedido->id . '" se ha borrado correctamente!');
        } catch (\Throwable $th) {
            abort(403, 'Bad Request');
        }
    }

    public function pedido()
    {
        $usuario = auth()->user();
        $pedidosUsuario = $usuario->order;
        $comprobarExistencia = $pedidosUsuario->isEmpty();
        return view('usuarios.pedidos.pedidos', compact('pedidosUsuario', 'comprobarExistencia'));
    }

    public function lineasPedido(Order $pedido)
    {
        if ($pedido->user_id == auth()->user()->id || auth()->user()->role == 1) {
            $lineasPedido = $pedido->orderLines;
            return view('usuarios.pedidos.lineasPedido', compact('lineasPedido', 'pedido'));
        } else {
            return back();
        }
    }
}
