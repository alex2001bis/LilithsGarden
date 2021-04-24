<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FotoController extends Controller
{
    public function create(){
        $productos = Product::all();
        return view('productos.imagenes.create', compact('productos'));

    }

    public function store(Request $request){
        
        $producto = Product::find($request->product);
        if ($request->hasFile('photo')) {
            $imagen['photo'] = $request->file('photo')->store('uploads/'.$producto->slug, 'public');
            $foto  = new Photo();
            $foto->product_id = $request->product;
            $foto->url = $imagen['photo'];
            $foto->save();
               
        }
        return redirect()->route('foto.create');
        

    }
}
