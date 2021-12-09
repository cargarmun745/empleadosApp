@php
  use App\Http\Controllers\IndexController;
@endphp

@extends ('base')

@section('masthead')
    <header class="masthead">
        <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
            <div class="d-flex justify-content-center">
                <div class="text-center">
                    <h1 class="mx-auto my-0 text-uppercase">Base de datos empleados</h1>
                    <h2 class="text-white-50 mx-auto mt-2 mb-5">Base de datos empleados</h2>
                    <a class="btn btn-primary" href="{{ url('puesto') }}">Base de Datos</a>
                </div>
            </div>
        </div>
    </header>
@endsection