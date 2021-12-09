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

    @if(Session::has('message'))
        <div class="alert alert-{{ session()->get('type') }}" role="alert">
            {{ session()->get('message') }}
        </div>
    @endif
<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			Listado de departamento
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
			            @foreach ($departamentos as $departamento)
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
								
			                    <td>
			                        <a href="{{ url('departamento/'.$departamento->id) }}">show</a>
			                    </td>
			                    <td>
			                        <a href="{{ url('departamento/'.$departamento->id.'/edit') }}">edit</a>
			                    </td>
			                    <td>
			                        <a href="javascript: void(0);" data-name="{{ $departamento->nombre }}" data-url="{{ url('departamento/' . $departamento->id) }}" data-toggle="modal" data-target="#modalDelete">delete</a>

			                    </td>
			                    <td></td>
			                </tr>
			            @endforeach
			        </tbody>
		        </table>
    			<a href="{{ url('departamento/create') }}" class="btn btn-default btn-lg" type="button">Añadir departamento</a>
    			@if(@isset($hayBorrados))
    				<br><br>
			        <a href="{{ url('departamento/recuperar') }}" class="btn btn-default btn-lg" type="button">Recuperar departamento</a>
			        @if($hayBorrados=='muchos')
			        	<a href="{{ url('departamento/recuperartodos') }}" class="btn btn-default btn-lg" type="button">Recuperar todos los departamentos</a>
			        @endif
			    @endif
    			
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