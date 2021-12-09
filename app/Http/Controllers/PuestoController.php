<?php

namespace App\Http\Controllers;

use App\Models\Puesto;
use App\Models\Empleado;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\PuestoCreateRequest;
use App\Http\Requests\PuestoEditRequest;

class PuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $puestos = Puesto::all();
        $data['puestos']=$puestos;
        $puestosBorrados = Puesto::onlyTrashed()->get()->count();
        if($puestosBorrados!=0){
            $borrados = 'muchos';
            if($puestosBorrados==1){
                $borrados = 'uno';
            }
            $data['hayBorrados']=$borrados;
        }
        return view('puesto/index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('puesto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PuestoCreateRequest $request)
    {
        // dd($request);
        $puesto = new Puesto($request->all());
        $data = [];
        $data['message'] = 'Se ha creado correctamente un nuevo puesto';
        $data['type'] = 'success';
        $puestos = Puesto::all();
        
        $puestosBorrados = Puesto::onlyTrashed()->get();
        
        foreach($puestosBorrados as $puestoBorrado){
            if($puestoBorrado->nombre==$request->nombre){
                Puesto::onlyTrashed()->find($puestoBorrado->id)->forceDelete();
            }
        }
        foreach($puestos as $puestoSolo){
            if($puestoSolo->nombre==$request->nombre){
                $data['message'] = 'El campo nombre de puesto debe ser único en la tabla de puesto.';
                return back()->withInput()->with($data);
            }
        }
        
        
        if($puesto->salarioMinimo>$puesto->salarioMaximo){
            $data['message'] = 'Los salarios son incorrectos, el salario minimo debe ser menor al salario máximo';
            $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        try{
            $result = $puesto ->save() ;
            // dd($result);
        }catch(\Exception $e){
            $result=false;
        }
        if(!$result){
            return back()->withInput()->with($data);
        }
        return redirect('puesto')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Puesto  $puesto
     * @return \Illuminate\Http\Response
     */
    public function show(Puesto $puesto)
    {
        $data = [];
        $data['puesto'] = $puesto;
        
        return view('puesto.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Puesto  $puesto
     * @return \Illuminate\Http\Response
     */
    public function edit(Puesto $puesto)
    {
        $data = [];
        $data['puesto'] = $puesto;
        return view('puesto.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Puesto  $puesto
     * @return \Illuminate\Http\Response
     */
    public function update(PuestoEditRequest $request, Puesto $puesto)
    {
        $data = [];
        $data['message'] = 'El puesto ' . $puesto->nombre . ' se ha actualizado correctamente';
        $data['type'] = 'success';
        
        $puestos = Puesto::all();
        $puestosBorrados = Puesto::onlyTrashed()->get();
        
        foreach($puestosBorrados as $puestoBorrado){
            if($puestoBorrado->nombre==$request->nombre){
                Puesto::onlyTrashed()->find($puestoBorrado->id)->forceDelete();
            }
        }
        foreach($puestos as $puestoSolo){
            if($puestoSolo->nombre==$request->nombre){
                if($puestoSolo->nombre .''. $puestoSolo->id!=$request->nombre .''. $puesto->id){
                    $data['message'] = 'El campo nombre de puesto debe ser único en la tabla de puesto.';
                    return back()->withInput()->with($data);
                }
            }
        }
        
        
        if($request->salarioMinimo>$request->salarioMaximo){
            $data['message'] = 'Los salarios son incorrectos, el salario minimo debe ser menor al salario máximo';
            $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        try{
            $result = $puesto ->update($request->all()) ;
            // dd($result);
        }catch(\Exception $e){
            $result=false;
        }
        if(!$result){
            // $data['message'] = 'The place can not be updated';
            // $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        return redirect('puesto')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Puesto  $puesto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Puesto $puesto)
    {
        $data = [];
        $empleados = Empleado::all();
        DB::beginTransaction();
        $data['message'] = 'El puesto ' . $puesto->nombre .' se ha borrado correctamente';
        $data['type'] = 'success';
        // try{
        //     foreach($empleados as $empleado){
        //         if($empleado->idpuesto==$puesto->id){
        //             $idpuesto=$empleado->idpuesto;
        //             $idp=$puesto->id;
        //             DB::table('empleado')
        //                 ->where("empleado.idpuesto", '=',  $idp)
        //                 ->update(['empleado.idpuesto'=> null]);
        //         }
        //     }
        // } catch (\Exception $e){
        //     DB::rollBack();
        //     return back()->withInput()->with($data);
        // }
        try{
            $result = $puesto->delete();
        } catch (\Exception $e){
            DB::rollBack();
            return back()->withInput()->with($data);
        }
        DB::commit();
        

        return redirect('puesto')->with($data);
    }
    
    // Recuperar los registros
    function recuperar(){
        $data = [];
        $puestos = Puesto::onlyTrashed()->get();
        $data['puestos']=$puestos;
        return view('puesto.recuperar', $data);
    }
    
    function recuperarSegundo(Request $request)
    {
        $data = [];
        DB::beginTransaction();
        $puestos = Puesto::onlyTrashed()->get();
        // dd($empleados);
        
        $data['message'] = 'Se han podido recuperar el puesto';
        $data['type'] = 'success';
        try{
            foreach($puestos as $puesto){
                if($puesto->id==$request->id){
                    Puesto::onlyTrashed()->find($puesto->id)->restore();
                }
            }
        } catch (\Exception $e){
            DB::rollBack();
            $data['message'] = 'No se han podido recuperar el empleado';
            $data['type'] = 'danger';
            return back()->with($data);
        }
        DB::commit();
        

        return redirect('puesto')->with($data);
    }
    
    function recuperarTodos(Request $request)
    {
        $data = [];
        $data['message'] = 'Se han podido recuperar los puestos';
        $data['type'] = 'success';
        try{
            Puesto::query()->restore();
        } catch (\Exception $e){
            DB::rollBack();
            $data['message'] = 'No se han podido recuperar los puestos';
            $data['type'] = 'danger';
            return back()->with($data);
        }
        DB::commit();
        
        return redirect('puesto')->with($data);
    }
}
