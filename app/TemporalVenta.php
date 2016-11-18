<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemporalVenta extends Model
{
    protected $table='temporal_venta';
    protected $primaryKey="idtemporal_venta";
    public $timestamps=false;
    protected $fillable =[
    	'idarticulo',
    	'codigo',
    	'nombre',
    	'stock'
    ];
    protected $guarded =[
    	
    ];
}
