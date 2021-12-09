<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Empleado;
use App\Models\Puesto;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\DepartamentoCreateRequest;
use App\Http\Requests\DepartamentoEditRequest;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $empleados = Empleado::all();
        $data['empleados']=$empleados;
        $departamentos = Departamento::all();
        $data['departamentos']=$departamentos;
        
        $departamentosBorrados = Departamento::onlyTrashed()->get()->count();
        if($departamentosBorrados!=0){
            $borrados = 'muchos';
            if($departamentosBorrados==1){
                $borrados = 'uno';
            }
            $data['hayBorrados']=$borrados;
        }
        
        return view('departamento.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('departamento.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartamentoCreateRequest $request)
    {
        $departamento = new Departamento($request->all());
        $data = [];
        $departamentos = Departamento::all();
        $data['message'] = 'Se ha creado correctamente un nuevo departamento';
        $data['type'] = 'success';
        
        $departamentosBorrados = Departamento::onlyTrashed()->get();
        $empleadosBorrados = Empleado::onlyTrashed()->get();
        
        foreach($departamentosBorrados as $departamentoBorrado){
            if($departamentoBorrado->nombre==$request->nombre){
                foreach($empleadosBorrados as $empleadoBorrado){
                    if($empleadoBorrado->iddepartamento==$departamentoBorrado->id){
                        Empleado::onlyTrashed()->find($empleadoBorrado->id)->forceDelete();
                    }
                }
                Departamento::onlyTrashed()->find($departamentoBorrado->id)->forceDelete();
            }
        }
            
        foreach($departamentos as $departamentoSolo){
            if($departamentoSolo->nombre==$request->nombre){
                $data['message'] = 'El campo nombre de departamento debe ser único en la tabla de departamento.';
                return back()->withInput()->with($data);
            }
        }
        try{
            $result = $departamento ->save() ;
            // dd($result);
        }catch(\Exception $e){
            $result=false;
        }
        if(!$result){
            return back()->withInput();
        }
        return redirect('departamento')->with($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function show(Departamento $departamento)
    {
        $data = [];
        $puestos = Puesto::all();
        $empleados = Empleado::all();
        // $data['empleados']=$empleados;
        $data['departamento']=$departamento;
        $empleadoDepartamento;
        $contador=0;
        
        // Muestra los empleados del departamento
        foreach($empleados as $empleado){
            if($empleado->iddepartamento==$departamento->id){
                $empleadoDepartamento[$contador]=$empleado;
                $contador++;
            }
        }
        if(!isset($empleadoDepartamento)){
            $empleadoDepartamento=null;
        }
        $data['empleados']= $empleadoDepartamento;
        // dd($data['empleados']!=null);
        $puestosTotales = DB::select('SELECT DISTINCT P.nombre, P.id, P.deleted_at FROM puesto P JOIN empleado E ON P.id = E.idpuesto JOIN departamento D ON D.id = E.iddepartamento
         WHERE D.id = :iddep', array('iddep' => $departamento->id));
        
        $puestosGenerales = DB::select('SELECT P.nombre, P.id, P.deleted_at FROM puesto P JOIN empleado E ON P.id = E.idpuesto JOIN departamento D ON D.id = E.iddepartamento
         WHERE D.id = :iddep', array('iddep' => $departamento->id));
         
        //  Obtencion de los puestos que hay en el departamento junto con los empleados
        $arrayPuestos;
         $i=0;
         $arrayEmpleados;
         $contadorEmpleados=0;
        foreach($puestosTotales as $puestosTot) {
            $contador=0;
            if($puestosTot->deleted_at==null){
                foreach($puestosGenerales as $puestosGe) {
                    if($puestosGe->deleted_at==null){
                        if($puestosGe->id==$puestosTot->id){
                            $contador++;
                        } 
                    }
                }
                $arrayEmpleados=[];
                foreach($empleados as $empleado){
                    
                    if($empleado->deleted_at==null){
                        
                        if($empleado->iddepartamento==$departamento->id){
                            
                            if($empleado->idpuesto==$puestosTot->id){
                                $arrayEmpleados[$contadorEmpleados]=$empleado;
                                $contadorEmpleados++;
                            }
                    
            
                            $arrayPuestos[$i]['nombre']=$puestosTot->nombre;
                            $arrayPuestos[$i]['contador']=$contadorEmpleados;
                            $arrayPuestos[$i]['empleados']=$arrayEmpleados;
                        
                        }
                        if($contadorEmpleados==0){
                            if($i==0){
                                $arrayPuestos=[];
                                $i--;
                            } else{
                                $arrayPuestos[$i]=null;
                                $i--;
                            }
                            
                        }
                        $i++;
                    }
                }
            }
        }
        
        // Obtencion de los salarios máximos y mínimos
        if(!isset($arrayPuestos)||$arrayPuestos==''){
            $arrayPuestos=null;
            $arrayPuestosSalarios=null;
        }else{
            $arraySalarios;
            $contador;
            foreach($puestos as $puesto) {
                // dd($arrayPuestos);
                foreach($arrayPuestos as $arrayPuesto) {
                    if($arrayPuesto['nombre']==$puesto->nombre){
                        $arrayPuestosSalarios[$contador]=$puesto;
                        $contador++;
                    }
                }
            }
        }
        
        $max=0;
        $min=0;
        if(isset($arrayPuestosSalarios)){
            foreach($arrayPuestosSalarios as $arrayPuestoSalario) {
                if($max==0 || $max<$arrayPuestoSalario->salarioMaximo){
                    $max=$arrayPuestoSalario->salarioMaximo;
                }if($min==0 || $min>$arrayPuestoSalario->salarioMinimo){
                    $min=$arrayPuestoSalario->salarioMinimo;
                }
            }
            $arraySalarios['min']=$min;
            $arraySalarios['max']=$max;
        }
            
        if(!isset($arraySalarios)){
            $arraySalarios=null;
        }
        
        // dd($arraySalarios);
        $data['arraySalarios']=$arraySalarios;
        $data['arrayPuestos']= $arrayPuestos;
        // dd($arrayPuestos[1]['nombre']);
        return view('departamento.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Departamento $departamento)
    {
        $data = [];
        $empleados = Empleado::all();
        $data['empleados']=$empleados;
        $data['departamento']=$departamento;
        // dd($departamento->idempleadojefe==null);
        return view('departamento.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function update(DepartamentoEditRequest $request, Departamento $departamento)
    {
        $data = [];
        $data['message'] = 'El departamento ' . $departamento->nombre . ' se ha actualizado correctamente';
        $data['type'] = 'success';
        
        $departamentos = Departamento::all();
        $departamentosBorrados = Departamento::onlyTrashed()->get();
        $empleadosBorrados = Empleado::onlyTrashed()->get();
        
        foreach($departamentosBorrados as $departamentoBorrado){
            if($departamentoBorrado->nombre==$request->nombre){
                foreach($empleadosBorrados as $empleadoBorrado){
                    if($empleadoBorrado->iddepartamento==$departamentoBorrado->id){
                        // dd(Empleado::onlyTrashed()->find($empleadoBorrado->id));
                        Empleado::onlyTrashed()->find($empleadoBorrado->id)->forceDelete();
                    }
                }
                Departamento::onlyTrashed()->find($departamentoBorrado->id)->forceDelete();
            }
        }
        foreach($departamentos as $departamentoSolo){
            if($departamentoSolo->nombre==$request->nombre){
                if($departamentoSolo->nombre .''. $departamentoSolo->id!=$request->nombre .''. $departamento->id){
                    $data['message'] = 'El campo nombre de departamento debe ser único en la tabla de departamento.';
                    return back()->withInput()->with($data);
                }
            }
        }
        
        try{
            $result = $departamento ->update($request->all()) ;
            // dd($result);
        }catch(\Exception $e){
            $result=false;
        }
        if(!$result){
            // $data['message'] = 'The place can not be updated';
            // $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        return redirect('departamento')->with($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departamento  $departamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departamento $departamento)
    {
        $data = [];
        $empleados = Empleado::all();
        DB::beginTransaction();
        $data['message'] = 'El departamento ' . $departamento->nombre .' y sus empleados asociados, se han borrado correctamente';
        $data['type'] = 'success';
        try{
            foreach($empleados as $empleado){
                if($empleado->iddepartamento==$departamento->id){
                    // if($empleado->id==$departamento->idempleadojefe){
                    //     $ide=$empleado->id;
                    //     DB::table('departamento')
                    //     ->where("departamento.idempleadojefe", '=',  $ide)
                    //     ->update(['departamento.idempleadojefe'=> null]);
                    // }
                    $empleado->delete();
                    
                }
                // dd($result1);
            }
        } catch (\Exception $e){
            DB::rollBack();
            return back()->withInput()->with($data);
        }
        try{
            $result = $departamento->delete();
        } catch (\Exception $e){
            DB::rollBack();
            return back()->withInput()->with($data);
        }
        DB::commit();
        

        return redirect('departamento')->with($data);
    }
    
    // Recuperar los registros
    function recuperar(){
        $data = [];
        $departamentos = Departamento::onlyTrashed()->get();
        $data['departamentos']=$departamentos;
        // dd($departamentos);
        return view('departamento.recuperar', $data);
    }
    
    function recuperarSegundo(Request $request)
    {
        $data = [];
        DB::beginTransaction();
        $empleados = Empleado::onlyTrashed()->get();
        // dd($empleados);
        
        $data['message'] = 'Se han podido recuperar el departamento y sus empleados relacionados';
        $data['type'] = 'success';
        try{
            Departamento::onlyTrashed()->find($request->id)->restore();
        } catch (\Exception $e){
            DB::rollBack();
            $data['message'] = 'No se han podido recuperar el departamento';
            $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        try{
            foreach($empleados as $empleado){
                if($empleado->iddepartamento==$request->id){
                    Empleado::onlyTrashed()->find($empleado->id)->restore();
                }
            }
        } catch (\Exception $e){
            DB::rollBack();
            $data['message'] = 'No se han podido recuperar el departamento';
            $data['type'] = 'danger';
            return back()->withInput()->with($data);
        }
        DB::commit();
        

        return redirect('departamento')->with($data);
    }
    
    function recuperarTodos(Request $request)
    {
        $data = [];
        $data['message'] = 'Se han podido recuperar los departamentos';
        $data['type'] = 'success';
        try{
            Departamento::query()->restore();
        } catch (\Exception $e){
            DB::rollBack();
            $data['message'] = 'No se han podido recuperar los departamentos';
            $data['type'] = 'danger';
            return back()->with($data);
        }
        DB::commit();
        
        return redirect('departamento')->with($data);
    }
}
