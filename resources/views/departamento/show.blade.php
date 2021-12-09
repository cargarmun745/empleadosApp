@extends ('admin.base')

@section ('header')
	<ul class="nav menu">
		<li><a href="{{ url('puesto') }}"><em class="fa fa-bar-chart">&nbsp;</em> Puesto</a></li>
		<li class="active"><a href="{{ url('departamento') }}"><em class="fa fa-bar-chart">&nbsp;</em> Departamento</a></li>
		<li><a href="{{ url('empleado') }}"><em class="fa fa-bar-chart">&nbsp;</em> Empleado</a></li>
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
            <p>¿Quieres borrar el departamento <span id="deleteDepartamento"></span> y todos sus empleados?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <form id="modalDeleteDepartamentoForm" action="" method="post">
                @method('delete')
                @csrf
                <input type="submit" class="btn btn-primary" value="Borrar departamento"/>
            </form>
          </div>
        </div>
      </div>
    </div>

<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Departamento</h1>
	</div>
</div><!--/.row-->

<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			Información del departamento
			<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
			<div class="panel-body">
				<table class="table table-hover">
					<thead>
			            <tr>
			            	<th></th><th></th>
			                <!--<th class="table-light" scope="col"># id</th>-->
			                <th class="table-light" scope="col">nombre</th>
			                <th class="table-light" scope="col">localizacion</th>
			                <th class="table-light" scope="col">empleadojefe</th>
			                <th></th>
			            </tr>
			        </thead>
			        <tbody>
			                <tr>
			                	<td></td><td></td>
			                    <!--<td>{{ $departamento->id }}</td>-->
			                    <td>{{ $departamento->nombre }}</td>
			                    <td>{{ $departamento->localizacion }}</td>
			                    @if(isset($departamento->idempleadojefe))
		            				@foreach($empleados as $empleado)
					                    @if( $departamento->idempleadojefe == $empleado->id )
					                    <td><a href="{{ url('empleado/'.$empleado->id) }}">{{ $empleado->nombre }}</a></td>
					                    	
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
			    <a href="{{ url('departamento/'.$departamento->id.'/edit') }}" class="btn btn-default btn-lg" type="button">Editar</a>   
			    <a href="javascript: void(0);" class="btn btn-default btn-lg" type="button" data-name="{{ $departamento->nombre }}" data-url="{{ url('departamento/' . $departamento->id) }}" data-toggle="modal" data-target="#modalDelete">Borrar</a>
			    <a href="{{ url('departamento') }}" class="btn btn-default btn-lg" type="button">Volver</a>
			</div>
		</div>
	</div><!-- cierre Row -->
	
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				Empleados de este departamento
				<span class="pull-right clickable panel-toggle panel-button-tab-left panel-collapsed"><em class="fa fa-toggle-down"></em></span></div>
				<div class="panel-body" style="display:none;">
					@if($empleados!=null)
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
					                <th class="table-light" scope="col">jefe</th>
					                <th></th>
					            </tr>
					        </thead>
					        <tbody>
						    	@foreach($departamento->empleados as $empleado)
					                <tr>
					                	<td></td><td></td>
					                    <!--<td>{{ $empleado->id }}</td>-->
					                    <td>{{ $empleado->nombre }}</td>
					                    <td>{{ $empleado->apellidos }}</td>
					                    <td>{{ $empleado->email }}</td>
					                    <td>{{ $empleado->telefono }}</td>
					                    <td>{{ $empleado->fechacontrato }}</td>
			            				@foreach($empleados as $empleado)
						                    @if( $empleado->id == $departamento->idempleadojefe )
						                    	<td>{{ $empleado->nombre }}</td>
						                    @endif
		            					@endforeach
					                    <td></td>
					                </tr>
						    	@endforeach
					        </tbody>
				        </table>
			        @else
			        	<p>No existen empleados de este departamento</p>
			        @endif
				</div>
			</div>
		</div><!-- cierre Row -->
		
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				Puestos del departamento
				<span class="pull-right clickable panel-toggle panel-button-tab-left panel-collapsed"><em class="fa fa-toggle-down"></em></span></div>
				<div class="panel-body" style="display:none;">
					@if($arrayPuestos!=null)
						<table class="table table-hover">
							<thead>
					            <tr>
					            	<th></th><th></th>
					                <!--<th class="table-light" scope="col"># id</th>-->
					                <th class="table-light" scope="col">puesto</th>
					                <th class="table-light" scope="col">numero de puestos</th>
					                <th class="table-light" scope="col">empleados con el puesto</th>
					                <th></th>
					            </tr>
					        </thead>
					        <tbody>
			            		@foreach($arrayPuestos as $arrayPuesto)
					                <tr>
					                	<td></td><td></td>
						                <td>{{ $arrayPuesto['nombre'] }}</td>
					                    <td>{{ $arrayPuesto['contador'] }}</td>
					                    <td>
			            				@foreach($arrayPuesto['empleados'] as $empleado)
						                    <a href="{{ url('empleado/'.$empleado->id) }}">{{ $empleado->nombre }}</a><br>
		            					@endforeach
		            					</td>
					                    <td></td>
					                </tr>
						    	@endforeach
					        </tbody>
				        </table>
			        @else
			        	<p>No existen puestos asociados con este departamento</p>
			        @endif
				</div>
			</div>
		</div><!-- cierre Row -->
		
		<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading">
				Salarios mínimos y máximos del departamento
				<span class="pull-right clickable panel-toggle panel-button-tab-left panel-collapsed"><em class="fa fa-toggle-down"></em></span></div>
				<div class="panel-body" style="display:none;">
					@if($arraySalarios!=null)
						<table class="table table-hover">
							<thead>
					            <tr>
					            	<th></th><th></th>
					                <!--<th class="table-light" scope="col"># id</th>-->
					                <th class="table-light" scope="col">Salario Maximo</th>
					                <th class="table-light" scope="col">Salario Minimo</th>
					                <th></th>
					            </tr>
					        </thead>
					        <tbody>
				                <tr>
				                	<td></td><td></td>
					                <td>{{ $arraySalarios['min'] }}</td>
				                    <td>{{ $arraySalarios['max'] }}</td>
				                    <td></td>
				                </tr>
					        </tbody>
				        </table>
			        @else
			        	<p>No existen salarios mínimos y máximos en este departamento</p>
			        @endif
				</div>
			</div>
		</div><!-- cierre Row -->
	</div>
	<div class="col-sm-12">
		<p class="back-link">Creado por Carmen García Muñoz</p>
	</div>
</div>	
@endsection

@section('js')
    <script src="{{ url('assets/js/deleteDepartamento.js') }}"></script>
@endsection