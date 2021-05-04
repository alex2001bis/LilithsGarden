@extends('layouts.app')
@section('title', 'Carrito')
@section('content')
    <h1>Carrito</h1>
    <div class="container">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $item)
                    <tr>
                        <td scope="row">{{ $item->name }}</td>
                        <td>
                            {{ \Cart::session(auth()->id())->get($item->id)->getPriceSum() }}
                        </td>
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}">
                                <input name="price" type="hidden"
                                    value="{{ \Cart::session(auth()->id())->get($item->id)->getPriceSum() }}"
                                    style="width: 50px;">
                                <input name="quantity" type="number" value="{{ $item->quantity }}" style="width: 50px;">
                                <button class="btn btn-success">Guardar</button>
                            </form>
                        </td>
                        <td><a href="{{ route('cart.delete', $item->id) }}" role="button"
                                class="btn btn-danger">Borrar</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h3>Precio total: {{ \Cart::session(auth()->id())->getTotal() }}&euro;</h3>
        <form action="{{ route('pedido.store') }}" method="post">
            @csrf
            <input type="hidden" name="deliveryAddress" id="deliveryAddress" value="{{ auth()->user()->deliveryAddress }}">
            <input type="hidden" name="carrito" value="{{ $cartItems }}">
            <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
            @foreach ($cartItems as $item)
                <input type="hidden" name='lineaPedido[{{ $numeroLineas }}][product_id]' value="{{ $item->id }}">
                <input type="hidden" name='lineaPedido[{{ $numeroLineas }}][quantity]' value="{{ $item->quantity }}">
                <input type="hidden" name='lineaPedido[{{ $numeroLineas }}][price]'
                    value="{{ \Cart::session(auth()->id())->get($item->id)->getPriceSum() }}">
                <span class="visually-hidden">{{ $numeroLineas++ }}</span>
            @endforeach
            <div class="mt-2 text-right"><button class="btn btn-primary shadow-none"
                    type="submit">{{ 'Comprar' }}</button>
            </div>
        </form>
    </div>
@endsection
