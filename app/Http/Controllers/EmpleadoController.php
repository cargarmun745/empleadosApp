<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Departamento;
use App\Models\Puesto;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\EmpleadoCreateRequest;
use App\Http\Requests\EmpleadoEditRequest;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = Empleado::all();
        $data['empleados']=$empleados;
        $empleadosBorrados = Empleado::onlyTrashed()->get()->count();
        if($empleadosBorrados!=0){
            $borrados = 'muchos';
            if($empleadosBorrados==1){
                $borrados = 'uno';
            }
            $data['hayBorrados']=$borrados;
        }
        return view('empleado/index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = [];
        $departamentos = Departamento::all();
        $data['departamentos']=$departamentos;
        $puestos = Puesto::all();
        $data['puestos']=$puestos;
        // dd($departamentos, $puestos);
        return view('empleado/create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmpleadoCreateRequest $request)
    {
        $empleado = new Empleado($request->all());
        $departamentos = Departamento::all();
        $data = [];
        $data['message'] = 'Se ha creado correctamente un nuevo empleado';
        $data['type'] = 'success';
        try{
            $result = $empleado ->save() ;
            // dd($result);
        }catch(\Exception $e){
            $result=false;
        }
        if(!$result){
            // $data['message'] = 'The place can not be inserted';
            // $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        // dd($request);
        if(isset($request->idempleadojefe)){
            foreach($departamentos as $departamento){
                if($departamento->id==(int)$empleado->iddepartamento){
                    
                     $iddepartamento = (int)$empleado->iddepartamento;
                     $idjefe = $empleado->id;
                    DB::table('departamento')
                        ->where("departamento.id", '=',  $iddepartamento)
                        ->update(['departamento.idempleadojefe'=> $idjefe]);
                }
            }
        }else{
            foreach($departamentos as $departamento){
                if($departamento->id==(int)$empleado->iddepartamento){
                    // dd($departamento->idempleadojefe);
                    if($departamento->idempleadojefe==(int)$empleado->id){
                    
                        $iddepartamento = (int)$empleado->iddepartamento;
                        DB::table('departamento')
                            ->where("departamento.id", '=',  $iddepartamento)
                            ->update(['departamento.idempleadojefe'=> null]);
                    }
                    
                }
            }
        }
        return redirect('empleado')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        $data = [];
        $data['empleado'] = $empleado;
        $departamentos = Departamento::all();
        $data['departamentos']=$departamentos;
        $puestos = Puesto::all();
        $data['puestos']=$puestos;
        $departamentosBorrados = Departamento::onlyTrashed()->get();
        $data['departamentosBorrados']=$departamentosBorrados;
        $puestosBorrados = Puesto::onlyTrashed()->get();
        $data['puestosBorrados']=$puestosBorrados;
        
        return view('empleado.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(Empleado $empleado)
    {
        $data = [];
        $data['empleado'] = $empleado;
        $departamentos = Departamento::all();
        $data['departamentos']=$departamentos;
        $puestos = Puesto::all();
        $data['puestos']=$puestos;
        return view('empleado.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(EmpleadoEditRequest $request, Empleado $empleado)
    {
        $data = [];
        $departamentos = Departamento::all();
        $data['message'] = 'El empleado ' . $empleado->nombre . ' se ha actualizado correctamente';
        $data['type'] = 'success';
        try{
            $result = $empleado ->update($request->all()) ;
            // dd($result);
        }catch(\Exception $e){
            $result=false;
        }
        if(!$result){
            // $data['message'] = 'The place can not be updated';
            // $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        if(isset($request->idempleadojefe)){
            foreach($departamentos as $departamento){
                if($departamento->id==(int)$empleado->iddepartamento){
                    
                     $iddepartamento = (int)$empleado->iddepartamento;
                     $idjefe = $empleado->id;
                    DB::table('departamento')
                        ->where("departamento.id", '=',  $iddepartamento)
                        ->update(['departamento.idempleadojefe'=> $idjefe]);
                }
            }
        }else{
            foreach($departamentos as $departamento){
                if($departamento->id==(int)$empleado->iddepartamento){
                    // dd($departamento->idempleadojefe);
                    if($departamento->idempleadojefe==(int)$empleado->id){
                    
                        $iddepartamento = (int)$empleado->iddepartamento;
                        DB::table('departamento')
                            ->where("departamento.id", '=',  $iddepartamento)
                            ->update(['departamento.idempleadojefe'=> null]);
                    }
                    
                }
            }
        }
        return redirect('empleado')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        $data = [];
        $departamentos = Departamento::all();
        DB::beginTransaction();
        $data['message'] = 'El empleado ' . $empleado->nombre .' se ha borrado correctamente';
        $data['type'] = 'success';
        try{
            foreach($departamentos as $departamento){
                if($empleado->iddepartamento==$departamento->id){
                    if($empleado->id==$departamento->idempleadojefe){
                        $ide=$empleado->id;
                        DB::table('departamento')
                        ->where("departamento.idempleadojefe", '=',  $ide)
                        ->update(['departamento.idempleadojefe'=> null]);
                    }
                    
                }
            }
        } catch (\Exception $e){
            // $data['message'] = 'The place' . $place->name .' has not been removed';
            // $data['type'] = 'danger';
            DB::rollBack(); //Se deshace todo menos el id provisional, que perdemos la posicion
            return back()->withInput()->with($data);
        }
        try{
            $result = $empleado->delete();
        } catch (\Exception $e){
            DB::rollBack();
            return back()->withInput()->with($data);
        }
        DB::commit();
        return redirect('empleado')->with($data);
    }
    
    // Recuperar los registros
    function recuperar(){
        $data = [];
        $empleados = Empleado::onlyTrashed()->get();
        $data['empleados']=$empleados;
        return view('empleado.recuperar', $data);
    }
    
    function recuperarSegundo(Request $request)
    {
        $data = [];
        DB::beginTransaction();
        $empleados = Empleado::onlyTrashed()->get();
        // dd($empleados);
        
        $data['message'] = 'Se han podido recuperar el empleado';
        $data['type'] = 'success';
        try{
            foreach($empleados as $empleado){
                if($empleado->id==$request->id){
                    Empleado::onlyTrashed()->find($empleado->id)->restore();
                }
            }
        } catch (\Exception $e){
            DB::rollBack();
            $data['message'] = 'No se han podido recuperar el empleado';
            $data['type'] = 'danger';
            return back()->with($data);
        }
        DB::commit();
        

        return redirect('empleado')->with($data);
    }
    
    function recuperarTodos(Request $request)
    {
        $data = [];
        $data['message'] = 'Se han podido recuperar los empleados';
        $data['type'] = 'success';
        try{
            Empleado::query()->restore();
        } catch (\Exception $e){
            DB::rollBack();
            $data['message'] = 'No se han podido recuperar los empleados';
            $data['type'] = 'danger';
            return back()->with($data);
        }
        DB::commit();
        
        return redirect('empleado')->with($data);
    }
}
