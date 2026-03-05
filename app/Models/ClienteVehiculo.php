<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClienteVehiculo extends Model
{
    use HasFactory;

    protected $table = 'cliente_vehiculo';

    protected $fillable = [
        'cliente_id',
        'vehiculo_id',
        'observaciones',
    ];

    // Relaciones
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'idCliente');
    }

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class, 'vehiculo_id', 'id');
    }

}
