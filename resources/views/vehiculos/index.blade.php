@extends('layouts.app')

<!DOCTYPE html>
<html>
<head>

<title>Vehículos</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body class="container mt-4">

<h2 align="center">Listado de Vehículos</h2>
<hr>

<div class="d-flex justify-content-end mb-3">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
        <i class="bi bi-person-plus me-1"></i> Nuevo Vehículo
    </button>
</div>


<!-- INICIA GRILLA PRINCIPAL-->

<div class="row mb-3">
    <div class="col-md-4 ms-auto">
        <form method="GET" action="{{ route('vehiculos.index') }}" class="d-flex">
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
            <th><a href="{{ route('vehiculos.index', ['sort'=>'id', 'placa'=>$sort=='id' && $placa=='asc' ? 'desc' : 'asc', 'search'=>request('search')]) }}" class="text-white text-decoration-none">ID</a></th>
            <th class="text-center"><a href="{{ route('vehiculos.index', ['sort'=>'placa', 'placa'=>$sort=='placa' && $direction=='asc' ? 'desc' : 'asc', 'search'=>request('search')]) }}" class="text-white text-decoration-none">PLACA</a></th>
            <th class="text-center"><a href="{{ route('vehiculos.index', ['sort'=>'marca', 'placa'=>$sort=='marca' && $direction=='asc' ? 'desc' : 'asc', 'search'=>request('search')]) }}" class="text-white text-decoration-none">MARCA</a></th>
            <th class="text-center"><a href="{{ route('vehiculos.index', ['sort'=>'modelo', 'placa'=>$sort=='modelo' && $direction=='asc' ? 'desc' : 'asc', 'search'=>request('search')]) }}" class="text-white text-decoration-none">MODELO</a></th>
            <th class="text-center"><a href="{{ route('vehiculos.index', ['sort'=>'anio_fabricacion', 'placa'=>$sort=='anio_fabricacion' && $direction=='asc' ? 'desc' : 'asc', 'search'=>request('search')]) }}" class="text-white text-decoration-none">AÑO FABRICACIÓN</a></th>
            
            <th class="text-center">ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vehiculos as $cliente)
        <tr>
            <td>{{ $cliente->id }}</td>
            <td>{{ $cliente->placa }}</td>
            <td>{{ $cliente->marca }}</td>
            <td>{{ $cliente->modelo }}</td>
            <td>{{ $cliente->anio_fabricacion }}</td>
         
            <td class="text-center">
                <button class="btn btn-warning btn-sm me-1"
                    data-bs-toggle="modal"
                    data-bs-target="#modalEditar"
                    onclick="editarCliente(
                        '{{ $cliente->id }}',
                        '{{ $cliente->placa }}',
                        '{{ $cliente->marca }}',
                        '{{ $cliente->modelo }}',
                        '{{ $cliente->anio_fabricacion }}'                       
                    )">
                    <i class="bi bi-pencil"></i> 
                </button>

                <button class="btn btn-danger btn-sm"
                    onclick="eliminarCliente({{ $cliente->id }}, '{{ $cliente->placa }}')">
                    <i class="bi bi-trash"></i> 
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-between align-items-center mt-2">
    <div>
        Mostrando {{ $vehiculos->firstItem() }} a {{ $vehiculos->lastItem() }} de {{ $vehiculos->total() }} resultados
    </div>
    <div>
        {{ $vehiculos->links('pagination::bootstrap-5') }}
    </div>
</div>


<!-- MODAL CREAR CLIENTE -->

<div class="modal fade" id="modalCrear" tabindex="-1">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <form id="formCliente">

                @csrf

                <div class="mb-3">
                    <label>Placa</label>
                    <input type="text" name="placa" class="form-control" >
                    <div class="invalid-feedback error-placa"></div>
                </div>

                <div class="mb-3">
                    <label>Marca</label>
                    <input type="text" name="marca" class="form-control" >
                    <div class="invalid-feedback error-marca"></div>
                </div>

                <div class="mb-3">
                    <label>Modelo</label>
                    <input type="text" name="modelo" class="form-control">
                    <div class="invalid-feedback error-modelo"></div>
                </div>

                <div class="mb-3">
                    <label>Año Fabricacion</label>
                    <input type="text" name="anio_fabricacion" class="form-control" maxlength="4"  >
                    <div class="invalid-feedback error-anio_fabricacion"></div>
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
                <h5 class="modal-title">Editar Vehículo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="formEditarCliente">
                    @csrf
                    @method('PUT') <!-- importante para update -->

                    <input type="hidden" name="id" id="editId">

                    <div class="mb-3">
                        <label>Placa</label>
                        <input type="text" name="placa" id="editPlaca" class="form-control">
                        <div class="invalid-feedback error-placa"></div>
                    </div>

                    <div class="mb-3">
                        <label>Marca</label>
                        <input type="text" name="marca" id="editMarca" class="form-control">
                        <div class="invalid-feedback error-marca"></div>
                    </div>

                    <div class="mb-3">
                        <label>Modelo</label>
                        <input type="text" name="modelo" id="editModelo" class="form-control" >
                        <div class="invalid-feedback error-modelo"></div>
                    </div>

                    <div class="mb-3">
                        <label>Año Fabricacion</label>
                        <input type="text" name="anio_fabricacion" id="editAnioFabricacion" class="form-control" maxlength="4">
                        <div class="invalid-feedback error-anio_fabricacion"></div>
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

document.querySelector('input[name="anio_fabricacion"]').addEventListener('input', function() {
    this.value = this.value.replace(/\D/g, ''); // elimina todo lo que no sea número
});




document.querySelector('input[id="editAnioFabricacion"]').addEventListener('input', function() {
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

fetch("/vehiculos",{

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
            title: "Vehículo registrado",
            text: "El Vehículo se guardó correctamente",
            confirmButtonText: "Aceptar"
        }).then(() => {

            form.reset();
            location.reload();

        });


    }

});

});

function editarCliente(id, placa, marca, modelo, anioFabricacion) {
    document.getElementById("editId").value = id;
    document.getElementById("editPlaca").value = placa;
    document.getElementById("editMarca").value = marca;
    document.getElementById("editModelo").value = modelo;
    document.getElementById("editAnioFabricacion").value = anioFabricacion;

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

    fetch(`/vehiculos/${id}`, {
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
                title: "Vehículo actualizado",
                text: "Los datos del Vehículo se actualizaron correctamente",
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
            fetch(`/vehiculos/${id}`, {
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
                        title: "Vehículo eliminado",
                        text: `El Vehículo ${nombre} fue eliminado correctamente`,
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
                    text: "Ocurrió un error al eliminar el Vehículo"
                });
            });
        }
    });
}

</script>
