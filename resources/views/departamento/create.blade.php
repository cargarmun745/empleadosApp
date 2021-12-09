@extends ('admin.base')

@section ('header')
	<ul class="nav menu">
		<li><a href="{{ url('puesto') }}"><em class="fa fa-bar-chart">&nbsp;</em> Puesto</a></li>
		<li><a href="{{ url('departamento') }}"><em class="fa fa-bar-chart">&nbsp;</em> Departamento</a></li>
		<li class="active"><a href="{{ url('empleado') }}"><em class="fa fa-bar-chart">&nbsp;</em> Empleado</a></li>
	</ul>
@endsection

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Empleado</h1>
	</div>
</div><!--/.row-->

<div class="row">
	<div class="panel panel-default">
		<div class="panel-heading">
			Creación de un empleado
			<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
			<div class="panel-body">
				<form class="form-horizontal" action="{{ url('empleado') }}" method="post">
        			@csrf
					<fieldset>
						
						<!-- Name input-->
						<div class="form-group">
							<label class="col-md-3 control-label" for="nombre">Nombre</label>
							<div class="col-md-9">
								<input value="{{ old('nombre') }}" id="nombre" name="nombre" type="text" placeholder="Nombre de empleado" class="form-control">
								@error('nombre')
						            <div class="alert alert-danger">{{ $message }}</div>
						        @enderror
							</div>
						</div>
						
						<!-- Apellidos input-->
						<div class="form-group">
							<label class="col-md-3 control-label" for="apellidos">Apellidos</label>
							<div class="col-md-9">
								<input value="{{ old('apellidos') }}" id="apellidos" name="apellidos" type="text" placeholder="Apellidos de empleado" class="form-control">
								@error('apellidos')
						            <div class="alert alert-danger">{{ $message }}</div>
						        @enderror
							</div>
						</div>
					
						<!-- Email input-->
						<div class="form-group">
							<label class="col-md-3 control-label" for="email">E-mail</label>
							<div class="col-md-9">
								<input value="{{ old('email') }}" id="email" name="email" type="email" placeholder="Email" class="form-control">
								@error('email')
						            <div class="alert alert-danger">{{ $message }}</div>
						        @enderror
							</div>
						</div>
						
						<!-- Telefono input-->
						<div class="form-group">
							<label class="col-md-3 control-label" for="telefono">Telefono</label>
							<div class="col-md-9">
								<input value="{{ old('telefono') }}" id="telefono" name="telefono" type="tel" placeholder="Telefono" class="form-control">
								@error('telefono')
						            <div class="alert alert-danger">{{ $message }}</div>
						        @enderror
							</div>
						</div>
						
						<!-- Fecha input-->
						<div class="form-group">
							<label class="col-md-3 control-label" for="fechacontrato">Fecha de contrato</label>
							<div class="col-md-9">
								<input value="{{ old('fechacontrato') }}" id="fechacontrato" name="fechacontrato" type="date" class="form-control">
								@error('fechacontrato')
						            <div class="alert alert-danger">{{ $message }}</div>
						        @enderror
							</div>
						</div>
						
						<!-- Puesto input-->
						<div class="form-group">
							<label class="col-md-3 control-label" for="idpuesto">Puesto asociado</label>
							<div class="col-md-9">
								<select name="idpuesto" class="form-control">
									<option value=""  @if (old('idpuesto') == "") selected @endif>&nbsp;</option>
						            @foreach ($puestos as $puesto)
						                    <option value="{{ $puesto->id }}" @if(old('idpuesto') == $puesto->id) selected @endif >{{ $puesto->nombre }}</option>
						            @endforeach
						        </select>
								@error('idpuesto')
						            <div class="alert alert-danger">{{ $message }}</div>
						        @enderror
							</div>
						</div>
						<!-- Departamento input-->
						<div class="form-group">
							<label class="col-md-3 control-label" for="iddepartamento">Departamento asociado</label>
							<div class="col-md-9">
								<select name="iddepartamento" class="form-control">
						            <option value="" selected="true"  @if (old('iddepartamento') == "") selected @endif>&nbsp;</option>
						            @foreach ($departamentos as $departamento)
						                    <option value="{{ $departamento->id }}" @if(old('iddepartamento') == $departamento->id) selected @endif >{{ $departamento->nombre }}</option>
						            @endforeach
						        </select>
								@error('iddepartamento')
						            <div class="alert alert-danger">{{ $message }}</div>
						        @enderror
							</div>
						</div>
						
						<!-- Check jefe input-->
						<div class="form-group">
							<label class="col-md-3 control-label" for="idempleadojefe">Jefe de departamento</label>
							<div class="col-md-9">
								<input type="checkbox" name="idempleadojefe" value="true">
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