@extends ('admin.base')

@section ('header')
	<ul class="nav menu">
		<li><a href="{{ url('puesto') }}"><em class="fa fa-bar-chart">&nbsp;</em> Puesto</a></li>
		<li class="active"><a href="{{ url('departamento') }}"><em class="fa fa-bar-chart">&nbsp;</em> Departamento</a></li>
		<li><a href="{{ url('empleado') }}"><em class="fa fa-bar-chart">&nbsp;</em> Empleado</a></li>
	</ul>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Departamento</h1>
	</div>
</div><!--/.row-->

<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			Edición del departamento
			<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
			<div class="panel-body">
				<form class="form-horizontal" action="{{ url('departamento/'.$departamento->id) }}" method="post">
			        @csrf
			        @method('put')
					<fieldset>
						<!-- Name input -->
						<div class="form-group">
							<label class="col-md-3 control-label" for="nombre">Nombre</label>
							<div class="col-md-9">
								<input value="{{ old('nombre', $departamento->nombre) }}"  id="nombre" name="nombre" type="text" placeholder="Nombre de departamento" class="form-control">
								@error('nombre')
						            <div class="alert alert-danger">{{ $message }}</div>
						        @enderror
						        @if(Session::has('message'))
							        <div class="alert alert-danger">
							            {{ session()->get('message') }}
							        </div>
							    @endif
							</div>
						</div>
					
						<!-- Localizacion input-->
						<div class="form-group">
							<label class="col-md-3 control-label" for="localizacion">Localización</label>
							<div class="col-md-9">
								<input value="{{ old('localizacion', $departamento->localizacion) }}" id="localizacion" name="localizacion" type="text" placeholder="Localización de departamento" class="form-control">
								@error('localizacion')
						            <div class="alert alert-danger">{{ $message }}</div>
						        @enderror
							</div>
						</div>
									
						<!--idempleadojefe-->
						<div class="form-group">
							<label class="col-md-3 control-label" for="idempleadojefe">Jefe de departamento</label>
							<div class="col-md-9">
								<select name="idempleadojefe" class="form-control">
						            <option value=""  @if($departamento->idempleadojefe==null) selected @endif>No definido</option>
						            @foreach ($empleados as $empleado)
						                    <option value="{{ $empleado->id }}"  @if($empleado->id==$departamento->idempleadojefe) selected @endif>{{ $empleado->nombre }}</option>
						            @endforeach
						        </select>
								@error('idempleadojefe')
						            <div class="alert alert-danger">{{ $message }}</div>
						        @enderror
						        
							</div>
						</div>
						
						<!-- Form actions -->
						<div class="form-group">
							<div class="col-md-12 widget-right">
								<button type="submit" class="btn btn-default btn-md pull-right">Submit</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>	<!-- cierre Row -->
<div class="col-sm-12">
	<p class="back-link">Creado por Carmen García Muñoz</p>
</div>
@endsection