<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = "clientes";

    protected $primaryKey = "idCliente";

    protected $fillable = [
        "nombre",
        "apellidos",
        "documento",
        "correo",
        "telefono"
    ];

}
