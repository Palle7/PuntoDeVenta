@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection


@section('main-content')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Usuario</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
					@endforeach
				</ul>
			</div>
			@endif

			{!!Form::open(array('url'=>'seguridad/usuario','method'=>'POST','autocomplete'=>'off'))!!}

			{{Form::token()}}

            <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                <label for="nombre" class="col-md-6 control-label">Nombre</label>
                <div class="col-md-6">
                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required autofocus placeholder="Nombre...">
                    @if ($errors->has('nombre'))
                        <span class="help-block">
                            <strong>{{ $errors->first('nombre') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

			<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-6 control-label">Nombre Usuario</label>
                <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Nombre usuario...">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-6 control-label">E-Mail</label>
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Email...">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-6 control-label">Password</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required placeholder="Password...">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                </div>
            </div>
            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password-confirm" class="col-md-6 control-label">Confirmar Password</label>
                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirmacion...">
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                </div>
            </div>


            <label for="direccion" class="col-md-6 control-label">Direccion</label>
            <div class="col-md-6">
                <input id="direccion" type="text" class="form-control" name="direccion"  value="{{old('direccion')}}" class="form-control" placeholder="Direccion...">
            </div>


            <label for="telefono" class="col-md-6 control-label">Telefono</label>
            <div class="col-md-6">
                <input type="text" name="telefono"  value="{{old('telefono')}}" class="form-control" placeholder="Telefono...">
            </div>

            <label for="edad" class="col-md-6 control-label">Edad</label>
            <div class="col-md-6">
                <input type="number" name="edad"  value="{{old('edad')}}" class="form-control" placeholder="Edad..." min=0 >
            </div>

            <label for="curp" class="col-md-6 control-label">CURP</label>
            <div class="col-md-6">
                <input type="text" name="curp"  value="{{old('curp')}}" class="form-control" placeholder="CURP...">
            </div>
            <label for="fecha_nacimiento" class="col-md-6 control-label">Fehca de Nacimiento</label>
            <div class="col-md-6">
                <input type="date" name="fecha_nacimiento"  value="{{old('fecha_nacimiento')}}" class="form-control" placeholder="Fecha...">
            </div>
		</div>
	</div>
    <div class="row">
    <br><br>
        <div >
            <div class="col-md-10">
                <button class="col-md-2 col-md-offset-4 btn btn-primary" type="submit">Guardar</button>
            </div>
            <div class="col-md-10">
            <br>
                <button class="col-md-2 col-sm-offset-4 btn btn-danger" type="reset">Cancelar</button>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
@endsection