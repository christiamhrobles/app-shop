<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use File;
class CategoryController extends Controller
{
    public function index(){
		$categories=Category::orderBy('id')->paginate(10);
		return view('admin.categories.index')->with(compact('categories')); //listado 
	}
	public function create(){
		return view('admin.categories.create'); //formulario de registro
	}
	public function store(Request $request){
		//validar
		$this->validate($request, Category::$rulers, Category::$messages);
		//registrar en la bd
		$category = Category::create($request->only('name','description'));//mass asignment

		if($request->hasFile('image')){
			$file = $request->file('image');
	    	$path = public_path() . '/images/categories'; //ruta de archivo
	    	$fileName = uniqid() .'-'. $file->getClientOriginalName(); //asigna nombre
	    	$moved = $file->move($path, $fileName); // guarda el archivo

	    	//creaar el registro 
	    	if($moved){
		    	$category->image = $fileName;
		    	$category->save();
	    	}
		}
		return redirect('/admin/categories');
	}

	public function edit(Category $category){
		//$category = Category::find($id);
		return view('admin.categories.edit')->with(compact('category')); //formulario de registro
	}
	public function update(Request $request, Category $category){
		//registrar l producto en la bd
		//dd($request->all());
		
		$this->validate($request, Category::$rulers, Category::$messages);
		//dd($request->input());
		$category->update($request->only('name','description'));	

		if($request->hasFile('image')){
			$file = $request->file('image');
	    	$path = public_path() . '/images/categories'; //ruta de archivo
	    	$fileName = uniqid() .'-'. $file->getClientOriginalName(); //asigna nombre
	    	$moved = $file->move($path, $fileName); // guarda el archivo

	    	//creaar el registro 
	    	if($moved){
	    		$previousPath = $path . '/' . $category->image; //// la ruta con el nombre de la imagen anterior

		    	$category->image = $fileName;
		    	$save = $category->save();
		    	//eliminar la imagen anterior
		    	if($save)	
		    		File::delete($previousPath);
	    	}
		}

		return redirect('/admin/categories');
	}

	public function destroy(Category $category){
		$category->delete(); //delete

		return back();
	}
}
