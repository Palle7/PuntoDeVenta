@extends('layouts.app')

@section('htmlheader_title')
	Home
@endsection


@section('main-content')
{!!Form::open(array('url'=>'ventas/venta','method'=>'POST','autocomplete'=>'off'))!!}
			{{Form::token()}}
	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div class="form-group">
				<label for="proveedor">Cliente</label>
				<select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true">
					@foreach($personas as $persona)
						<option value="{{$persona->idpersona}}">{{$persona->nombre}}</option>
					@endforeach
				</select>
			</div>
		</div>
	</div>
	{!!Form::close()!!}
		<div class="row">
		{!! Form::open(array('url'=>'ventas/venta/create','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
		<div class="form-group">
			<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
				<div class="input-group">
				<input type="text" id="campoBusca" class="form-control" name="searchText" placeholder="Buscar..." >
					<span class="input-group-btn">
						<button type="submit" class="btn btn-primary " id="bt_add">Buscar</button>
					</span>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
		{{Form::close()}}
	</div>
	<br>
	<br>
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<div class="form-group">
						<button type="button" id="calisConAgregar" class="btn btn-warning" >Cancelar Compra</button>
					</div>
				</div>
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<table href="#!" id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color: #A9D0F5">
							<th>Opciones</th>
							<th>Articulo</th>
							<th>Cantidad</th>
							<th>Cantidad Total</th>
							<th>Precio Venta</th>
							<th>Subtotal</th>
						</thead>
						<tfoot>
						@foreach ($retVenta as $art)
						 <tr data-id="{{$art->idtemporal_venta}}">
				          <td>
							{{Form::Open(array('action'=>array('VentaController@destroy', $art->idtemporal_venta),'method'=>'delete'))}}
							<button type="submit" class="btn btn-danger">Eliminar</button>
							{{Form::Close()}}
				          </td>
				          <td>
				            {{ $art->nombre}}
				          </td>
				          <td class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
				          {!!Form::open(array('url'=> array("http://localhost:8000/cantidad/$art->idtemporal_venta"),'method'=>'PUT','autocomplete'=>'off'))!!}
								{{Form::token()}}
				            <div class="form-group form-group-sm" >
								<div class="input-group">
								
								<input type="number" id="cantidad" class="form-control" name="cantidad">
									<span class="input-group-btn">
										<button type="submit" class="btn btn-info btn-sm" id="bt_add" >Cambiar</button>
									</span>
								<input name"_token" value="{{csrf_token()}}" type="hidden"></input>
								{!!Form::close()!!}
								</div>
							</div>
				          </td>
				          <td class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
				          	{{$art->cantidad}}
				          </td>
				          <td>
				            {{$art->precio}}
				          </td>
				          <td>
				          	{{$art->subtotal}}
				          </td>
				        </tr>
				        @endforeach
							<th>TOTAL</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th><h2 id="total" name="total">$  {{ $total }}</h2>
								<input type="hidden" name="total_venta" if="total_venta" id="total_venta">
							</th>
						</tfoot>
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
			<div class="form-group">
				<input name"_token" value="{{csrf_token()}}" type="hidden"></input>

						<!-- Button trigger modal -->
				<button class="btn btn-success" type="submit" id="botonAceptarVenta" onclick ="limpiaAbono()" data-toggle="modal" data-target="#myModal">
				  Aceptar Venta
				</button>

				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h2 class="modal-title" id="myModalLabel">Confirmar Venta</h4>
				      </div>
				      <div class="modal-body">


				      <div class="col-md-6 col-md-offset-4">
					      <h3>
					      	<label for="confPalle" id="confPalle">Total $ {{ $total }}</label>
					      </h3>
					      <input type="text" name="calis" id="calis" required value="{{ $total}}" >
				      </div>


				

					<div class="form-group">
				     	<div class="col-md-6 col-md-offset-3">
							<div class="input-group">
							<input type="text" min=0 id="cantidadAbono" class="form-control"   onchange="muestra()" name="cantidadAbono" placeholder="Cantidad...">
								<span class="input-group-btn">
									<button type="submit" class="btn btn-primary " id="enterAbono" onclick="muestra()">Enter</button>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-md-offset-4">
						<h3>
							<label id="restante"></label>
						</h3>
					</div>
				</div>
				      <br><br><br><br><br><br><br><br>

				      <div class="modal-footer">
				        <button type="button" class="btn btn-default" id="descartar" onclick="limpiaAbono()" data-dismiss="modal">Descartar</button>
				        <button type="submit" id="botonRealizarVenta" class="btn btn-success">Realizar Venta</button>
				      </div>
				    </div>
				  </div>
				</div>
			</div>
		</div>	
	</div>	
@push('scripts')
<script>
var flg =1;
var total;
window.onload = function() {
    document.getElementById("campoBusca").focus();
    	$("#restante").hide();
     	$("#calis").hide();
     	$("#botonRealizarVenta").hide();
};
	$(document).ready(function(){
		$('#calisConAgregar').click(function(e){
			//e.preventDefault();
			$("#campoBusca").val("");
			$("#bt_add").click();
			$.get("/elimina");
		});
	});
	function limpiaAbono(){
		flg=1;
		$("#restante").hide();
		$("#botonRealizarVenta").hide();
	}
	function muestra(){
		
		$("#restante").show();
		
		//var text1 = document.getElementById('calis').innerHTML;
		if(flg==1){
			flg=0;
			total = $("#calis").val() - $("#cantidadAbono").val();
			if(total==0){
				$("#botonRealizarVenta").show();
			}
			else{
				$("#botonRealizarVenta").hide();
			}
		}
		else{
			total = total- $("#cantidadAbono").val();
			if(total==0){
				$("#botonRealizarVenta").show();
			}
			else{
				$("#botonRealizarVenta").hide();
			}
		}
		$("#restante").html("Restante: $ "+total);
		$("#cantidadAbono").val("");
	}
	$(document).ready(function(e){
		$('#botonRealizarVenta').click(function(){
			var st1 = $("#idcliente").val();
			var st2 = "/store/";
			$.get(st2.concat(st1));
			///$("#myModal").hide();
			
			$("#descartar").click();
			$("#campoBusca").val("");
			$("#bt_add").click();
		});
	});
	

</script>
@endpush
@endsection