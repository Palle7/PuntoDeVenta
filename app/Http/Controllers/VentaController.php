<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\VentaFormRequest;
use App\Http\Requests\TemporalVentaFormRequest;
use App\Venta;
use App\DetalleVenta;
use App\TemporalVenta;
use DB;
use App\User;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(Request $request){
    	if($request){
    		$query=trim($request->get('searchText'));
    		$ventas=DB::table('venta as v')
    		->join('persona as p','v.idcliente','=','p.idpersona')
    		->join('detalle_venta as dv','v.idventa','=','dv.idventa')
    		->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.numero_comprobante','v.impuesto','v.estado','v.total_venta')
    		->where('v.numero_comprobante','LIKE','%'.$query.'%')
    		->orderBy('v.idventa','desc')
    		->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.numero_comprobante','v.impuesto','v.estado')
    		->paginate(7);
    		return view("ventas.venta.index",["ventas"=>$ventas,"searchText"=>$query]);
    	}
    }
    public function create(Request $request){
        $total=0; 
        if($request){
            $query=trim($request->get('searchText'));
            $articulos=DB::table('articulo as a')
            ->join('categoria as c', 'a.idcategoria','=','c.idcategoria')
            ->select('a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado')
            ->where('a.nombre','LIKE','%'.$query.'%')
            ->orwhere('a.codigo','LIKE','%'.$query.'%')
            ->orderBy('a.idarticulo','desc')
            ->get();
        }
    	$personas=DB::table('persona')->where('tipo_persona','=','Cliente')
        ->orderBy('persona.nombre','asc')
        ->get();
    	$articulos=DB::table('articulo as art')
    		->join('detalle_ingreso as di','art.idarticulo','=','di.idarticulo')
    		->select(DB::raw('CONCAT(art.codigo," ",art.nombre) AS articulo'),'art.codigo','art.nombre','art.idarticulo','art.precio','art.stock',DB::raw('avg(di.precio_venta) as precio_promedio'))
    		->where('art.estado','=','Activo')
    		->where('art.stock','>','0')
            ->where('art.nombre','LIKE','%'.$query.'%')
            ->orwhere('art.codigo','LIKE','%'.$query.'%')
    		->groupBy('articulo','art.idarticulo','art.stock')
    		->get();
           
            if($query == NULL){
            }
            else{
                
               foreach ($articulos as $arr) {
                    try{
                        DB::beginTransaction();
                        $venta = new TemporalVenta;
                        $venta->idarticulo=$arr->idarticulo;
                        $venta->codigo=$arr->codigo;
                        $venta->nombre=$arr->nombre;
                        $venta->stock=$arr->stock;
                        $venta->precio=$arr->precio;
                        $venta->cantidad=1;
                        $venta->save();

                        $venta->subtotal=($venta->cantidad * $arr->precio);
                        $venta->save();
                        DB::commit();
                        
                        
                    }catch(\Exception $e){
                    DB::rollback();
                   }
                        
                }  
            }
            $retVenta=DB::table('temporal_venta')->get();
            foreach ($retVenta as $retV) {
                $total=$total+$retV->subtotal;
            }

		return view('ventas.venta.create',["personas"=>$personas,"articulos"=>$articulos, "searchText"=>$query, "retVenta"=>$retVenta, "total"=>$total]);
    }

    public function store($id, $vendedor){
        $total=0;
    	//try{
            $retVenta=DB::table('temporal_venta')->get();
            foreach ($retVenta as $retV) {
                $total=$total+$retV->subtotal;
            }
    		DB::beginTransaction();
        	$venta = new Venta;
    		$venta->idcliente=$id;
    		$venta->total_venta=$total;
    		$mytime = Carbon::now('America/Tijuana');
    		$venta->fecha_hora=$mytime->toDateTimeString();
    		$venta->estado='A';
            $venta->idvendedor=$vendedor;
    		$venta->save();

            foreach ($retVenta as $dV) {
                $detalle = new DetalleVenta();
                $detalle->idventa=$venta->idventa;
                $detalle->idarticulo=$dV->idarticulo;
                $detalle->cantidad=$dV->cantidad;
                $detalle->precio_venta=$dV->subtotal;
                $detalle->save();
            }
    		DB::commit();
    	//}catch(\Exception $e){
    	//	DB::rollback();
    	//}

    	$venta = new TemporalVenta;
        $venta = DB::delete('delete from temporal_venta')
        ->where('temporal_venta.idventatemporal');
        return Redirect::to('ventas/venta');
    }

    public function show($id){
    	$venta = DB::table('venta as v')
    		->join('persona as p','v.idcliente','=','p.idpersona')
    		->join('detalle_venta as dv','v.idventa','=','dv.idventa')
    		->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.numero_comprobante','v.impuesto','v.estado','v.total_venta')
    		->where('v.idventa','=',$id)
    		->first();

    	$detalles=DB::table('detalle_venta as d')
    		->join('articulo as a','d.idarticulo','=','a.idarticulo')
    		->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta')
    		->where('d.idventa','=',$id)
    		->get();
    	return view("ventas.venta.show",["venta"=>$venta,"detalles"=>$detalles]);
    }

    public function destroy($id){
        $venta = TemporalVenta::find($id);
        $venta ->delete();
        return Redirect::to('ventas/venta/create');
    }

    public function eliminaTemporalVenta(){
        $venta = new TemporalVenta;
        $venta = DB::delete('delete from temporal_venta')
        ->where('temporal_venta.idventatemporal');
        return Redirect::to('ventas/venta');
    }

    public function cantidadPro($id, Request $request){
        $personas=DB::table('persona')->where('tipo_persona','=','Cliente')->get();
        $articulos=DB::table('articulo as art')
            ->join('detalle_ingreso as di','art.idarticulo','=','di.idarticulo')
            ->select(DB::raw('CONCAT(art.codigo," ",art.nombre) AS articulo'),'art.codigo','art.nombre','art.idarticulo','art.precio','art.stock',DB::raw('avg(di.precio_venta) as precio_promedio'))
            ->where('art.estado','=','Activo')
            ->where('art.stock','>','0')
            ->get();

        $cantidad=trim($request->get('cantidad'));

        $venta = TemporalVenta::find($id);
        $venta->cantidad = $cantidad;
        $venta->subtotal=($cantidad * $venta->precio);
        $venta->save();

        $total=0;

        $retVenta=DB::table('temporal_venta')->get();
        foreach ($retVenta as $retV) {
                $total=$total+$retV->subtotal;
        }
    return view('ventas.venta.create',["personas"=>$personas,"articulos"=>$articulos, "retVenta"=>$retVenta, "total"=>$total]);
    }
}
