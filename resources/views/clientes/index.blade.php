@extends('layouts.app')

<!DOCTYPE html>
<html>
<head>

<title>Clientes</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body class="container mt-4">

<h2 align="center">Listado de Clientes</h2>
<hr>

<div class="d-flex justify-content-end mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
        <i class="bi bi-person-plus me-1"></i> Nuevo Cliente
    </button>
</div>


<!-- INICIA GRILLA PRINCIPAL-->

<div class="row mb-3">
    <div class="col-md-4 ms-auto">
        <form method="GET" action="{{ route('clientes.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Buscar..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="bi bi-search"></i> Buscar
            </button>
        </form>
    </div>
</div>

<table class="table table-bordered table-hover align-middle" id="listadoClientes">
    <thead class="table-dark">
        <tr>
            <th><a href="{{ route('clientes.index', ['sort'=>'idCliente', 'direction'=>$sort=='idCliente' && $direction=='asc' ? 'desc' : 'asc', 'search'=>request('search')]) }}" class="text-white text-decoration-none">ID</a></th>
            <th class="text-center"><a href="{{ route('clientes.index', ['sort'=>'nombre', 'direction'=>$sort=='nombre' && $direction=='asc' ? 'desc' : 'asc', 'search'=>request('search')]) }}" class="text-white text-decoration-none">NOMBRE</a></th>
            <th class="text-center"><a href="{{ route('clientes.index', ['sort'=>'apellidos', 'direction'=>$sort=='apellidos' && $direction=='asc' ? 'desc' : 'asc', 'search'=>request('search')]) }}" class="text-white text-decoration-none">APELLIDOS</a></th>
            <th class="text-center"><a href="{{ route('clientes.index', ['sort'=>'documento', 'direction'=>$sort=='documento' && $direction=='asc' ? 'desc' : 'asc', 'search'=>request('search')]) }}" class="text-white text-decoration-none">NRO. DOCUMENTO</a></th>
            <th class="text-center"><a href="{{ route('clientes.index', ['sort'=>'correo', 'direction'=>$sort=='correo' && $direction=='asc' ? 'desc' : 'asc', 'search'=>request('search')]) }}" class="text-white text-decoration-none">CORREO</a></th>
            <th class="text-center"><a href="{{ route('clientes.index', ['sort'=>'telefono', 'direction'=>$sort=='telefono' && $direction=='asc' ? 'desc' : 'asc', 'search'=>request('search')]) }}" class="text-white text-decoration-none">TELÉFONO</a></th>
            <th class="text-center">ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clientes as $cliente)
        <tr>
            <td>{{ $cliente->idCliente }}</td>
            <td>{{ $cliente->nombre }}</td>
            <td>{{ $cliente->apellidos }}</td>
            <td>{{ $cliente->documento }}</td>
            <td>{{ $cliente->correo }}</td>
            <td>{{ $cliente->telefono }}</td>
            <td class="text-center">
                <button class="btn btn-warning btn-sm me-1"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditar"
                    onclick="editarCliente(
                        '{{ $cliente->idCliente }}',
                        '{{ $cliente->nombre }}',
                        '{{ $cliente->apellidos }}',
                        '{{ $cliente->documento }}',
                        '{{ $cliente->correo }}',
                        '{{ $cliente->telefono }}'
                    )">
                    <i class="bi bi-pencil"></i> 
                </button>

                <button class="btn btn-danger btn-sm"
                    onclick="eliminarCliente({{ $cliente->idCliente }}, '{{ $cliente->nombre }}')">
                    <i class="bi bi-trash"></i> 
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center mt-2">
    <div>
        Mostrando {{ $clientes->firstItem() }} a {{ $clientes->lastItem() }} de {{ $clientes->total() }} resultados
    </div>
    <div>
        {{ $clientes->links('pagination::bootstrap-5') }}
    </div>
</div>


<!-- MODAL CREAR CLIENTE -->

<div class="modal fade" id="modalCrear" tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="formCliente">

                @csrf

                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control">
                    <div class="invalid-feedback error-nombre"></div>
                </div>

                <div class="mb-3">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" class="form-control">
                    <div class="invalid-feedback error-apellidos"></div>
                </div>

                <div class="mb-3">
                    <label>Nro Documento</label>
                    <input type="text" name="documento" class="form-control" maxlength="8"  >
                    <div class="invalid-feedback error-documento"></div>
                </div>

                <div class="mb-3">
                    <label>Correo</label>
                    <input type="email" name="correo" class="form-control">
                    <div class="invalid-feedback error-correo"></div>
                </div>

                <div class="mb-3">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" class="form-control" maxlength="9">
                    <div class="invalid-feedback error-telefono"></div>
                </div>

                </form>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                Cerrar
                </button>

                <button type="button" class="btn btn-primary" id="btnGuardarCliente">
                Guardar Cliente
                </button>

            </div>

        </div>
    </div>
</div>


<!-- MODAL EDITAR CLIENTE -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="formEditarCliente">
                    @csrf
                    @method('PUT') <!-- importante para update -->

                    <input type="hidden" name="idCliente" id="editId">

                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="editNombre" class="form-control">
                        <div class="invalid-feedback error-nombre"></div>
                    </div>

                    <div class="mb-3">
                        <label>Apellidos</label>
                        <input type="text" name="apellidos" id="editApellidos" class="form-control">
                        <div class="invalid-feedback error-apellidos"></div>
                    </div>

                    <div class="mb-3">
                        <label>Nro Documento</label>
                        <input type="text" name="documento" id="editDocumento" class="form-control" maxlength="8">
                        <div class="invalid-feedback error-documento"></div>
                    </div>

                    <div class="mb-3">
                        <label>Correo</label>
                        <input type="email" name="correo" id="editCorreo" class="form-control">
                        <div class="invalid-feedback error-correo"></div>
                    </div>

                    <div class="mb-3">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" id="editTelefono" class="form-control" maxlength="9">
                        <div class="invalid-feedback error-telefono"></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnActualizarCliente">Actualizar Cliente</button>
            </div>

        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

document.querySelector('input[name="documento"]').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, ''); // elimina todo lo que no sea número
});

document.querySelector('input[name="telefono"]').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, ''); // elimina todo lo que no sea número
});



document.querySelector('input[id="editDocumento"]').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, ''); // elimina todo lo que no sea número
});

document.querySelector('input[id="editTelefono"]').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, ''); // elimina todo lo que no sea número
});

   

document.getElementById("btnGuardarCliente").addEventListener("click", function(){

let form = document.getElementById("formCliente");
let formData = new FormData(form);

// limpiar errores
document.querySelectorAll(".form-control").forEach(input=>{
    input.classList.remove("is-invalid");
});

document.querySelectorAll(".invalid-feedback").forEach(error=>{
    error.innerText="";
});

fetch("/clientes",{

method:"POST",

headers:{
"X-CSRF-TOKEN":document.querySelector('input[name="_token"]').value,
"Accept":"application/json"
},

body:formData

})
.then(response=>{

if(response.status===422){

    return response.json().then(data=>{

        let errores = data.errors;

        for(let campo in errores){

            let input = document.querySelector(`[name="${campo}"]`);
            let error = document.querySelector(".error-"+campo);

            if(input){
                input.classList.add("is-invalid");
            }

            if(error){
                error.innerText = errores[campo][0];
            }

        }

    });

}

return response.json();

})
.then(data=>{

    if(data.success){

        Swal.fire({
            icon: "success",
            title: "Cliente registrado",
            text: "El cliente se guardó correctamente",
            confirmButtonText: "Aceptar"
        }).then(() => {

            form.reset();
            location.reload();

        });


    }

});

});

function editarCliente(id, nombre, apellidos, documento, correo, telefono) {
    document.getElementById("editId").value = id;
    document.getElementById("editNombre").value = nombre;
    document.getElementById("editApellidos").value = apellidos;
    document.getElementById("editDocumento").value = documento;
    document.getElementById("editCorreo").value = correo;
    document.getElementById("editTelefono").value = telefono;

    // limpiar errores
    document.querySelectorAll("#formEditarCliente .form-control").forEach(input=>{
        input.classList.remove("is-invalid");
    });
    document.querySelectorAll("#formEditarCliente .invalid-feedback").forEach(error=>{
        error.innerText = "";
    });
}

// funcion actualizar cliente

document.getElementById("btnActualizarCliente").addEventListener("click", function(){

    let form = document.getElementById("formEditarCliente");
    let formData = new FormData(form);
    let id = document.getElementById("editId").value;

    // limpiar errores
    document.querySelectorAll("#formEditarCliente .form-control").forEach(input=>{
        input.classList.remove("is-invalid");
    });
    document.querySelectorAll("#formEditarCliente .invalid-feedback").forEach(error=>{
        error.innerText = "";
    });

    fetch(`/clientes/${id}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
            "Accept": "application/json"
        },
        body: formData
    })
    .then(response => {
        if(response.status === 422){
            return response.json().then(data => {
                let errores = data.errors;
                for(let campo in errores){
                    let input = document.querySelector(`#formEditarCliente [name="${campo}"]`);
                    let error = document.querySelector(`#formEditarCliente .error-${campo}`);
                    if(input) input.classList.add("is-invalid");
                    if(error) error.innerText = errores[campo][0];
                }
            });
        }
        return response.json();
    })
    .then(data => {
        if(data.success){
            Swal.fire({
                icon: "success",
                title: "Cliente actualizado",
                text: "Los datos del cliente se actualizaron correctamente",
                confirmButtonText: "Aceptar"
            }).then(() => {
                location.reload(); // recargar la grilla
            });
        }
    });

});

function eliminarCliente(id, nombre) {
    Swal.fire({
        title: `¿Estás seguro de eliminar a ${nombre}?`,
        text: "¡Esta acción no se puede deshacer!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/clientes/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                    "Accept": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    Swal.fire({
                        icon: "success",
                        title: "Cliente eliminado",
                        text: `El cliente ${nombre} fue eliminado correctamente`,
                        confirmButtonText: "Aceptar"
                    }).then(() => {
                        location.reload(); // recargar la grilla
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Ocurrió un error al eliminar el cliente"
                });
            });
        }
    });
}

</script>
