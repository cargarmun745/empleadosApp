@extends ('admin.base')

@section ('header')
	<ul class="nav menu">
		<li><a href="{{ url('puesto') }}"><em class="fa fa-bar-chart">&nbsp;</em> Puesto</a></li>
		<li><a href="{{ url('departamento') }}"><em class="fa fa-bar-chart">&nbsp;</em> Departamento</a></li>
		<li class="active"><a href="{{ url('empleado') }}"><em class="fa fa-bar-chart">&nbsp;</em> Empleado</a></li>
	</ul>
@endsection

@section('content')

    <div class="modal" id="modalDelete" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Confirmar borrado</h5>
          </div>
          <div class="modal-body">
            <p>¿Quieres borrar el empleado <span id="deleteEmpleado"></span>?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <form id="modalDeleteEmpleadoForm" action="" method="post">
                @method('delete')
                @csrf
                <input type="submit" class="btn btn-primary" value="Borrar empleado"/>
            </form>
          </div>
        </div>
      </div>
    </div>
    
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Empleado</h1>
	</div>
</div><!--/.row-->

<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			Información del empleados
			<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
			<div class="panel-body">
				<table class="table table-hover">
					<thead>
			            <tr>
			            	<th></th><th></th>
			                <!--<th class="table-light" scope="col"># id</th>-->
			                <th class="table-light" scope="col">nombre</th>
			                <th class="table-light" scope="col">apellidos</th>
			                <th class="table-light" scope="col">email</th>
			                <th class="table-light" scope="col">telefono</th>
			                <th class="table-light" scope="col">fechacontrato</th>
			                <th class="table-light" scope="col">puesto</th>
			                <th class="table-light" scope="col">departamento</th>
			                <th></th>
			            </tr>
			        </thead>
			        <tbody>
			                <tr>
			                	<td></td><td></td>
			                    <!--<td>{{ $empleado->id }}</td>-->
			                    <td>{{ $empleado->nombre }}</td>
			                    <td>{{ $empleado->apellidos }}</td>
			                    <td>{{ $empleado->email }}</td>
			                    <td>{{ $empleado->telefono }}</td>
			                    <td>{{ $empleado->fechacontrato }}</td>
			                    
	            				
								@if(isset($empleado->idpuesto))
		            				@foreach($puestos as $puesto)
					                    @if( $empleado->idpuesto == $puesto->id )
					                    	<td>{{ $puesto->nombre }}</td>
					                    @endif
	            					@endforeach
	            					@foreach($puestosBorrados as $puestoBorrado)
					                    @if( $empleado->idpuesto == $puestoBorrado->id )
					                    	<td>Puesto borrado<br><br>
					                    	
					                    	<form class="form-horizontal" action="{{ url('puesto/recuperarsegundo') }}" method="post">
			        							@csrf
												<input type="hidden" name="id" value="{{ $puestoBorrado->id }}">
												<p>Recuperar puesto</p>
												<button type="submit" class="btn btn-default btn-md pull-right">Recuperar</button>
											</form>
											
											</td>
					                    @endif
	            					@endforeach
            					@else 
            						<td>No definido</td>
				                @endif
            					
				                
	            				@if(isset($empleado->iddepartamento))
		            				@foreach($departamentos as $departamento)
					                    @if( $empleado->iddepartamento == $departamento->id )
					                    	<td>{{ $departamento->nombre }}</td>
					                    @endif
	            					@endforeach
	            					@foreach($departamentosBorrados as $departamentoBorrado)
					                    @if( $empleado->iddepartamento == $departamentoBorrado->id )
					                    	<td>Departamento borrado<br><br>
					                    	
					                    	<form class="form-horizontal" action="{{ url('departamento/recuperarsegundo') }}" method="post">
			        							@csrf
												<input type="hidden" name="id" value="{{ $departamentoBorrado->id }}">
												<p>Recuperar departamento y sus empleados asociados</p>
												<button type="submit" class="btn btn-default btn-md pull-right">Recuperar</button>
											</form>
											
											</td>
					                    @endif
	            					@endforeach
            					@else 
            						<td>No definido</td>
				                @endif
			                    
			                    
			                    <td></td>
			                </tr>
			        </tbody>
		        </table>
			    <br>
			    <a href="{{ url('empleado/'.$empleado->id.'/edit') }}" class="btn btn-default btn-lg" type="button">Editar</a>   
			    <a href="javascript: void(0);" class="btn btn-default btn-lg" type="button" data-name="{{ $empleado->nombre }}" data-url="{{ url('empleado/' . $empleado->id) }}" data-toggle="modal" data-target="#modalDelete">Borrar</a>
			    <a href="{{ url('empleado') }}" class="btn btn-default btn-lg" type="button">Volver</a>
			</div>
		</div>
	</div>
</div>	<!-- cierre Row -->
<div class="col-sm-12">
	<p class="back-link">Creado por Carmen García Muñoz</p>
</div>
@endsection

@section('js')
    <script src="{{ url('assets/js/deleteEmpleado.js') }}"></script>
@endsection