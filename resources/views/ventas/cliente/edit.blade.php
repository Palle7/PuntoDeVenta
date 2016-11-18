@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection


@section('main-content')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Cliente: {{ $persona->nombre}}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>
			{!!Form::model($persona,['method'=>'PATCH','route'=>['cliente.update',$persona->idpersona]])!!}
			{{Form::token()}}
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
					<label for="nombre">Nombre</label>
					<input type="text" name="nombre" required value="{{$persona->nombre}}" class="form-control" placeholder="Nombre...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
					<label for="codigo_empleado">Codigo Empleado</label>
					<input type="text" name="codigo_empleado"  value="{{$persona->codigo_empleado}}" class="form-control" placeholder="Codigo...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
					<label for="aval">Aval</label>
					<input type="text" name="aval"  value="{{$persona->aval}}" class="form-control" placeholder="Aval...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
					<label for="limite_cuenta">Limite de cuenta</label>
					<input type="number" name="limite_cuenta"  value="{{$persona->limite_cuenta}}" class="form-control" placeholder="Limite..." min=100>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
					<label for="direccion">Direccion</label>
					<input type="text" name="direccion"  value="{{$persona->direccion}}" class="form-control" placeholder="Direccion...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
					<label for="email">Email</label>
					<input type="email" name="email"  value="{{$persona->email}}" class="form-control" placeholder="Email...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
					<label for="telefono">Telefono</label>
					<input type="text" name="telefono"  value="{{$persona->telefono}}" class="form-control" placeholder="Telefono...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
					<label for="edad">Edad</label>
					<input type="number" name="edad"  value="{{$persona->edad}}" class="form-control" placeholder="Edad..." min=0 >
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
					<label for="curp">CURP</label>
					<input type="text" name="curp"  value="{{$persona->curp}}" class="form-control" placeholder="CURP...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
					<label for="fecha_nacimiento">Fehca de Nacimiento</label>
					<input type="date" name="fecha_nacimiento"  value="{{$persona->fecha_nacimiento}}" class="form-control" placeholder="Fecha...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>	
	</div>	
			
			{!!Form::close()!!}
@endsection