@extends ('admin.base')

@section ('header')
	<ul class="nav menu">
		<li class="active"><a href="{{ url('puesto') }}"><em class="fa fa-bar-chart">&nbsp;</em> Puesto</a></li>
		<li><a href="{{ url('departamento') }}"><em class="fa fa-bar-chart">&nbsp;</em> Departamento</a></li>
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
            <p>¿Quieres borrar el puesto <span id="deletePuesto"></span>?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <form id="modalDeletePuestoForm" action="" method="post">
                @method('delete')
                @csrf
                <input type="submit" class="btn btn-primary" value="Borrar puesto"/>
            </form>
          </div>
        </div>
      </div>
    </div>
    
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Puesto</h1>
	</div>
</div><!--/.row-->

<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			Información del puesto
			<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
			<div class="panel-body">
				<table class="table table-hover">
					<thead>
			            <tr>
			            	<th></th><th></th>
			                <!--<th class="table-light" scope="col"># id</th>-->
			                <th class="table-light" scope="col">nombre</th>
			                <th class="table-light" scope="col">salario minimo</th>
			                <th class="table-light" scope="col">salario maximo</th>
			                <th></th>
			            </tr>
			        </thead>
			        <tbody>
			                <tr>
			                	<td></td><td></td>
			                    <!--<td>{{ $puesto->id }}</td>-->
			                    <td>{{ $puesto->nombre }}</td>
			                    <td>{{ $puesto->salarioMinimo }}</td>
			                    <td>{{ $puesto->salarioMaximo }}</td>
			                    <td></td>
			                </tr>
			        </tbody>
		        </table>
			    <br>
			    <a href="{{ url('puesto/'.$puesto->id.'/edit') }}" class="btn btn-default btn-lg" type="button">Editar</a>   
			    <a href="javascript: void(0);" class="btn btn-default btn-lg" type="button" data-name="{{ $puesto->nombre }}" data-url="{{ url('puesto/' . $puesto->id) }}" data-toggle="modal" data-target="#modalDelete">Borrar</a>
			    <a href="{{ url('puesto') }}" class="btn btn-default btn-lg" type="button">Volver</a>
			</div>
		</div>
	</div>
</div>	<!-- cierre Row -->
<div class="col-sm-12">
	<p class="back-link">Creado por Carmen García Muñoz</p>
</div>
@endsection

@section('js')
    <script src="{{ url('assets/js/deletePuesto.js') }}"></script>
@endsection