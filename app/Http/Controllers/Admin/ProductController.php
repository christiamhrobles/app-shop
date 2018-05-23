<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;

class ProductController extends Controller
{
	public function index(){
		$products=Product::paginate(10);
		return view('admin.products.index')->with(compact('products')); //listado 
	}
	public function create(){
		$categories = Category::orderBy('name')->get();
		return view('admin.products.create')->with(compact('categories')); //formulario de registro
	}
	public function store(Request $request){
		//validar
		$messages =[
			'name.required' => 'Es necesario ingresar un nombre para el producto.',
			'name.min' => 'El de producto debe tener al menos 3 caracteres.',
			'description.required' => 'La descripcion corta es un campo obligatorio.',
			'description.max' => 'La descripcion corta solo admite hasta 200 caracteres.',
			'price.required' => 'Es obligatirio definir un precio para el producto.',
			'price.numeric' => 'Ingrese un precio valido.',
			'price.min' => 'No se admiten valores negativos.'
		];
		$rulers= [
			'name' =>'required|min:3',
			'description' =>'required|max:200',
			'price' =>'required|numeric|min:0'
		];
		$this->validate($request, $rulers, $messages);
		//registrar el producto en la bd
		$product = new Product();
		$product->name = $request->input('name');
		$product->description = $request->input('description');
		$product->price = $request->input('price');
		$product->long_description = $request->input('long_description ');
		$product->category_id = $request->category_id;
		$product->save(); //insert

		return redirect('/admin/products');
	}

	public function edit($id){
		$product = Product::find($id);
		$categories = Category::orderBy('name')->get();
		return view('admin.products.edit')->with(compact('product','categories')); //formulario de registro
	}
	public function update(Request $request,$id){
		//registrar l producto en la bd
		//dd($request->all());
		$messages =[
			'name.required' => 'Es necesario ingresar un nombre para el producto.',
			'name.min' => 'El de producto debe tener al menos 3 caracteres.',
			'description.required' => 'La descripcion corta es un campo obligatorio.',
			'description.max' => 'La descripcion corta solo admite hasta 200 caracteres.',
			'price.required' => 'Es obligatirio definir un precio para el producto.',
			'price.numeric' => 'Ingrese un precio valido.',
			'price.min' => 'No se admiten valores negativos.'
		];
		$rulers= [
			'name' =>'required|min:3',
			'description' =>'required|max:200',
			'price' =>'required|numeric|min:0'
		];
		$this->validate($request, $rulers, $messages);
		//dd($request->input());
		$product = Product::find($id);
		$product->name = $request->input('name');
		$product->description = $request->input('description');
		$product->price = $request->input('price');
		$product->long_description = $request->input('long_description');
		$product->category_id = $request->category_id;
		$product->save(); //update

		return redirect('/admin/products');
	}

	public function destroy($id){
		$product = Product::find($id);
		$product->delete(); //delete

		return back();
	}
}
