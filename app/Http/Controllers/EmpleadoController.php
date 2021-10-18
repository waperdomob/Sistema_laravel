<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datos['empleados'] = Empleado::paginate(1);
        return view('empleado.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('empleado.create',[
            'empleado' => new Empleado(),
            'categories' => Category::pluck('name','id')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $fields = request()->validate([
            'name'=>'required|string|max:100',
            'lastname'=>'required|string|max:100',
            'email'=>'required|email',
            'category_id'=>'required|integer|max:20',
            'photo'=>'required|max:10000|mimes:jpeg,png,jpg',
            
        ]);
        $message = [
            'name'=>'required',
            'lastname'=>'required',
            'email'=>'required',
            'photo'=>'required',
            'category_id'=>'required'
        ];

        $this->validate($request,$fields,$message);

        $datosEmpleado = request()->except('_token');

        if ($request->hasfile('photo')) {
                $datosEmpleado['photo'] = $request->file('photo')->store('uploads','public');
        }
        Empleado::insert($datosEmpleado);
        return redirect()->route('empleado.index')->with('mensaje','El empleado fue agregado con exito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
        $categories = Category::pluck('name','id');
        return $categories;
        return view('empleado.edit',['empleado'=>$empleado,
        'categories' => Category::pluck('name','id')]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $fields = [
            'name'=>'required|string|max:100',
            'lastname'=>'required|string|max:100',
            'email'=>'required|email',
            'category_id'=>'required|integer|max:20'            
        ];
        $message = [
            'name'=>'required',
            'lastname'=>'required',
            'email'=>'required',
            'category_id'=>'required'         
        ];
        if ($request->hasfile('photo')){

            $fields = ['photo'=>'required|max:10000|mimes:jpeg,png,jpg'];
            $message = ['photo'=>'required'];
        }

        $this->validate($request,$fields,$message);
        
        $datosEmpleado = $request->except(['_token','_method']);

        if ($request->hasfile('photo')) {
            $empleado = Empleado::findOrfail($id);
            Storage::delete(['public/'. $empleado->photo]);
            $datosEmpleado['photo'] = $request->file('photo')->store('uploads','public');
        }
        Empleado::where('id','=',$id)->update($datosEmpleado);

        $empleado = Empleado::findOrfail($id);
        //return redirect()->route('empleado.index',$empleado);
        return redirect()->route('empleado.index')->with('mensaje','El empleado ha sido actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $empleado = Empleado::findOrfail($id);
        if (Storage::delete(['public/'. $empleado->photo]))
         {
            Empleado::destroy($id);
        }
       
        return redirect()->route('empleado.index')->with('mensaje','El empleado ha sido eliminado');
    }
}
