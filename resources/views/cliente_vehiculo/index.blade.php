@extends('layouts.app')

<!DOCTYPE html>
<html>
<head>

<title>Encuesta Vehículo</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body class="container mt-4">

<h2 align="center">Encuesta Vehículo</h2>
<hr>

<div class="d-flex justify-content-end mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
        <i class="bi bi-plus-circle me-1"></i> Nuevo Registro
    </button>
</div>


<!-- BUSCADOR -->

<div class="row mb-3">
    <div class="col-md-4 ms-auto">
        <form method="GET" action="{{ route('cliente_vehiculo.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm me-2"
                placeholder="Buscar..." value="{{ request('search') }}">

            <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-search"></i> Buscar
            </button>
        </form>
    </div>
</div>



<!-- TABLA -->

<table class="table table-bordered table-hover align-middle">

<thead class="table-dark">

<tr>
<th>ID</th>
<th class="text-center">CLIENTE</th>
<th class="text-center">VEHÍCULO</th>
<th class="text-center">OBSERVACIONES</th>
<th class="text-center">ACCIONES</th>
</tr>

</thead>

<tbody>

@foreach($registros as $registro)

<tr>

<td>{{ $registro->id }}</td>

<td>
{{ $registro->cliente->nombre }}
{{ $registro->cliente->apellidos }}
</td>

<td>
{{ $registro->vehiculo->placa }} -
{{ $registro->vehiculo->marca }}
{{ $registro->vehiculo->modelo }}
</td>

<td>{{ $registro->observaciones }}</td>

<td class="text-center">

<button class="btn btn-warning btn-sm me-1"
data-bs-toggle="modal"
data-bs-target="#modalEditar"
onclick="editarRegistro(
'{{ $registro->id }}',
'{{ $registro->cliente_id }}',
'{{ $registro->vehiculo_id }}',
`{{ $registro->observaciones }}`
)">
<i class="bi bi-pencil"></i>
</button>

<button class="btn btn-danger btn-sm"
onclick="eliminarRegistro({{ $registro->id }})">
<i class="bi bi-trash"></i>
</button>

</td>

</tr>

@endforeach

</tbody>

</table>



<!-- PAGINACIÓN -->

<div class="d-flex justify-content-between align-items-center mt-2">

<div>
Mostrando {{ $registros->firstItem() }}
a {{ $registros->lastItem() }}
de {{ $registros->total() }} resultados
</div>

<div>
{{ $registros->links('pagination::bootstrap-5') }}
</div>

</div>



<!-- MODAL CREAR -->

<div class="modal fade" id="modalCrear" tabindex="-1">

<div class="modal-dialog">

<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Nuevo Registro Cliente-Vehículo</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<form id="formRegistro">

@csrf

<div class="mb-3">
<label>Cliente</label>

<select name="cliente_id" class="form-control">

<option value="">Seleccione un cliente</option>

@foreach($clientes as $cliente)

<option value="{{ $cliente->idCliente }}">
{{ $cliente->nombre }} {{ $cliente->apellidos }}
</option>

@endforeach

</select>

<div class="invalid-feedback error-cliente_id"></div>

</div>


<div class="mb-3">
<label>Vehículo</label>

<select name="vehiculo_id" class="form-control">

<option value="">Seleccione un vehículo</option>

@foreach($vehiculos as $vehiculo)

<option value="{{ $vehiculo->id }}">
{{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}
</option>

@endforeach

</select>

<div class="invalid-feedback error-vehiculo_id"></div>

</div>


<div class="mb-3">

<label>Observaciones</label>

<textarea name="observaciones" class="form-control"></textarea>

</div>

</form>

</div>


<div class="modal-footer">

<button class="btn btn-secondary" data-bs-dismiss="modal">
Cerrar
</button>

<button class="btn btn-primary" id="btnGuardarRegistro">
Guardar
</button>

</div>

</div>

</div>

</div>



<!-- MODAL EDITAR -->

<div class="modal fade" id="modalEditar" tabindex="-1">

<div class="modal-dialog">

<div class="modal-content">

<div class="modal-header">
<h5 class="modal-title">Editar Registro</h5>
<button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<form id="formEditarRegistro">

@csrf
@method('PUT')

<input type="hidden" id="editId">

<div class="mb-3">

<label>Cliente</label>

<select name="cliente_id" id="editCliente" class="form-control">

@foreach($clientes as $cliente)

<option value="{{ $cliente->idCliente }}">
{{ $cliente->nombre }} {{ $cliente->apellidos }}
</option>

@endforeach

</select>

</div>


<div class="mb-3">

<label>Vehículo</label>

<select name="vehiculo_id" id="editVehiculo" class="form-control">

@foreach($vehiculos as $vehiculo)

<option value="{{ $vehiculo->id }}">
{{ $vehiculo->placa }} - {{ $vehiculo->marca }} {{ $vehiculo->modelo }}
</option>

@endforeach

</select>

</div>


<div class="mb-3">

<label>Observaciones</label>

<textarea name="observaciones" id="editObservaciones" class="form-control"></textarea>

</div>

</form>

</div>

<div class="modal-footer">

<button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

<button class="btn btn-primary" id="btnActualizarRegistro">
Actualizar
</button>

</div>

</div>

</div>

</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>



document.getElementById("btnGuardarRegistro").addEventListener("click",function(){

let form=document.getElementById("formRegistro");
let data=new FormData(form);

fetch("/cliente_vehiculo",{

method:"POST",

headers:{
"X-CSRF-TOKEN":document.querySelector('input[name="_token"]').value,
"Accept":"application/json"
},

body:data

})
.then(res=>res.json())
.then(data=>{

if(data.success){

Swal.fire({
icon:"success",
title:"Registro guardado",
confirmButtonText:"Aceptar"
}).then(()=>{
location.reload();
});

}

});

});



function editarRegistro(id,cliente,vehiculo,obs){

document.getElementById("editId").value=id;
document.getElementById("editCliente").value=cliente;
document.getElementById("editVehiculo").value=vehiculo;
document.getElementById("editObservaciones").value=obs;

}



document.getElementById("btnActualizarRegistro").addEventListener("click",function(){

let form=document.getElementById("formEditarRegistro");
let data=new FormData(form);
let id=document.getElementById("editId").value;

fetch(`/cliente_vehiculo/${id}`,{

method:"POST",

headers:{
"X-CSRF-TOKEN":document.querySelector('input[name="_token"]').value,
"Accept":"application/json"
},

body:data

})
.then(res=>res.json())
.then(data=>{

if(data.success){

Swal.fire({
icon:"success",
title:"Registro actualizado"
}).then(()=>{
location.reload();
});

}

});

});



function eliminarRegistro(id){

Swal.fire({
title:"¿Eliminar registro?",
icon:"warning",
showCancelButton:true,
confirmButtonText:"Eliminar"
}).then(result=>{

if(result.isConfirmed){

fetch(`/cliente_vehiculo/${id}`,{

method:"DELETE",

headers:{
"X-CSRF-TOKEN":document.querySelector('input[name="_token"]').value,
"Accept":"application/json"
}

})
.then(res=>res.json())
.then(data=>{

if(data.success){

Swal.fire({
icon:"success",
title:"Registro eliminado"
}).then(()=>{
location.reload();
});

}

});

}

});

}

</script>

</body>
</html>