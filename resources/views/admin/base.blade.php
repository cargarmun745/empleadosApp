<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gestión</title>
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ url('assets/css/font-awesome.min.css') }}" rel="stylesheet">
	<link href="{{ url('assets/css/datepicker3.css') }}" rel="stylesheet">
	<link href="{{ url('assets/css/styles.css') }}" rel="stylesheet">
	@yield('css')

</head>
<body>
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>
				<a class="navbar-brand" href="#"><span>Gestion</span>Admin</a>
				<ul class="nav navbar-top-links navbar-right">
					<li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
						<em class="fa fa-envelope"></em></a>
					</li>
					<li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
						<em class="fa fa-bell"></em></a>
					</li>
				</ul>
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<!--<form role="search">-->
		<!--	<div class="form-group">-->
		<!--		<input type="text" class="form-control" placeholder="Search">-->
		<!--	</div>-->
		<!--</form>-->
		
        @section('header')
			<ul class="nav menu">
				<li><a href="{{ url('puesto') }}"><em class="fa fa-bar-chart">&nbsp;</em> Puesto</a></li>
				<li><a href="{{ url('departamento') }}"><em class="fa fa-bar-chart">&nbsp;</em> Departamento</a></li>
				<li><a href="{{ url('empleado') }}"><em class="fa fa-bar-chart">&nbsp;</em> Empleado</a></li>
			</ul>
		@show
	</div><!--/.sidebar-->
		
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="{{ url('/') }}">
					<em class="fa fa-home"></em>
				</a></li>
			</ol>
		</div><!--/.row-->
		
	    <div id="content">
	    	@yield('content')
			
		</div> <!-- cierre content -->
		
	</div>	<!--/.main-->
	  

	<script src="{{ url('assets/js/jquery-1.11.1.min.js') }}"></script>
	<script src="{{ url('assets/js/bootstrap.min.js') }}"></script>
	<script src="{{ url('assets/js/chart.min.js') }}"></script>
	<script src="{{ url('assets/js/chart-data.js') }}"></script>
	<script src="{{ url('assets/js/easypiechart.js') }}"></script>
	<script src="{{ url('assets/js/easypiechart-data.js') }}"></script>
	<script src="{{ url('assets/js/bootstrap-datepicker.js') }}"></script>
	<script src="{{ url('assets/js/custom.js') }}"></script>
	@yield('js')
	
</body>
</html>
