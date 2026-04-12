@extends('layouts.coordinador')

@section('content')
<div class="container-fluid px-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-person-plus me-2 text-primary"></i>Crear Tutor
            </h2>
            <p class="text-muted">Registra un nuevo tutor académico en el sistema</p>
        </div>
        <a href="/coordinador/tutores" class="btn btn-light rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>

    <!-- Formulario -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-person-badge me-2 text-primary"></i>Información del tutor
            </h5>
        </div>
        <div class="card-body p-4">
            
            @if ($errors->any())
                <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4" style="background-color: #fef2f2; border-left: 4px solid #ef4444;">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-exclamation-triangle-fill text-danger mt-1"></i>
                        <div>
                            <strong class="text-danger">Por favor, corrige los siguientes errores:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li class="small">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="/coordinador/tutores">
                @csrf

                <div class="row g-4">
                    
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small text-muted mb-2">
                            <i class="bi bi-person me-1"></i>Nombre completo
                        </label>
                        <input type="text" 
                               name="nombre" 
                               class="form-control rounded-pill px-3 @error('nombre') is-invalid @enderror"
                               value="{{ old('nombre') }}" 
                               placeholder="Ej. Juan Pérez García"
                               style="height: 45px;">
                        @error('nombre')
                            <div class="invalid-feedback ms-2">{{ $message }}</div>
                        @enderror
                        <small class="text-muted ms-2">Mínimo 3 caracteres</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small text-muted mb-2">
                            <i class="bi bi-envelope me-1"></i>Correo electrónico
                        </label>
                        <input type="email" 
                               name="correo" 
                               class="form-control rounded-pill px-3 @error('correo') is-invalid @enderror"
                               value="{{ old('correo') }}" 
                               placeholder="ejemplo@utnay.edu.mx"
                               style="height: 45px;">
                        @error('correo')
                            <div class="invalid-feedback ms-2">{{ $message }}</div>
                        @enderror
                        <small class="text-muted ms-2">El correo será utilizado para el acceso</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small text-muted mb-2">
                            <i class="bi bi-tag me-1"></i>Área de especialización
                        </label>
                        <input type="text" 
                               name="area" 
                               class="form-control rounded-pill px-3 @error('area') is-invalid @enderror"
                               value="{{ old('area') }}" 
                               placeholder="Ej. Ingeniería en Sistemas, Matemáticas, Física..."
                               style="height: 45px;">
                        @error('area')
                            <div class="invalid-feedback ms-2">{{ $message }}</div>
                        @enderror
                        <small class="text-muted ms-2">Especialidad académica del tutor</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold small text-muted mb-2">
                            <i class="bi bi-diagram-3 me-1"></i>Grupos asignados
                        </label>
                        <select name="grupos[]" 
                                class="form-select @error('grupos') is-invalid @enderror" 
                                multiple 
                                size="5"
                                style="border-radius: 16px; padding: 12px;">
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}"
                                    {{ collect(old('grupos'))->contains($grupo->id) ? 'selected' : '' }}
                                    style="padding: 8px 12px; border-radius: 8px; margin-bottom: 4px;">
                                    <i class="bi bi-people-fill me-2"></i>{{ $grupo->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('grupos')
                            <div class="invalid-feedback d-block ms-2">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Mantén presionada la tecla <kbd class="bg-light rounded px-2">Ctrl</kbd> (Windows/Linux) o 
                                <kbd class="bg-light rounded px-2">Cmd</kbd> (Mac) para seleccionar múltiples grupos
                            </small>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted d-flex align-items-center gap-2">
                                <i class="bi bi-lightbulb text-warning"></i>
                                <span>Puedes seleccionar varios grupos manteniendo presionada la tecla Ctrl/Cmd</span>
                            </small>
                        </div>
                    </div>

                </div>

                <div class="mt-5 pt-3 d-flex justify-content-end gap-3">
                    <a href="/coordinador/tutores" class="btn btn-light rounded-pill px-4 py-2">
                        <i class="bi bi-x-lg me-2"></i>Cancelar
                    </a>
                    <button type="submit" class="btn rounded-pill px-4 py-2 text-white" style="background: linear-gradient(135deg, #1f7a5c 0%, #0f5e46 100%);">
                        <i class="bi bi-save me-2"></i>Guardar tutor
                    </button>
                </div>

            </form>

        </div>
    </div>

    <!-- Información adicional -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-light" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start gap-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-info-circle-fill text-primary fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-2">Información importante</h6>
                            <p class="text-muted small mb-0">
                                Al crear un tutor, se generará automáticamente una cuenta de acceso con contraseña temporal <strong>12345678</strong>. 
                                El tutor podrá cambiar su contraseña en su primer inicio de sesión.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #1f7a5c;
        box-shadow: 0 0 0 3px rgba(31, 122, 92, 0.1);
    }
    
    .form-control.is-invalid:focus, .form-select.is-invalid:focus {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }
    
    select[multiple] option {
        padding: 8px 12px;
        border-radius: 8px;
        margin-bottom: 4px;
        transition: all 0.2s;
    }
    
    select[multiple] option:hover {
        background-color: #f1f5f9;
    }
    
    select[multiple] option:checked {
        background: linear-gradient(135deg, #1f7a5c 0%, #0f5e46 100%);
        color: white;
    }
    
    .dark-mode select[multiple] option:checked {
        background: linear-gradient(135deg, #1f7a5c 0%, #0f5e46 100%);
    }
    
    .dark-mode select[multiple] option:hover {
        background-color: #334155;
    }
    
    kbd {
        font-family: monospace;
        padding: 2px 6px;
        font-size: 12px;
        background-color: #eef2f6;
        border-radius: 6px;
        box-shadow: inset 0 -1px 0 rgba(0,0,0,0.1);
    }
    
    .dark-mode kbd {
        background-color: #334155;
        color: #e2e8f0;
        box-shadow: inset 0 -1px 0 rgba(0,0,0,0.3);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const nombre = document.querySelector('input[name="nombre"]');
    const correo = document.querySelector('input[name="correo"]');
    const area = document.querySelector('input[name="area"]');
    const grupos = document.querySelector('select[name="grupos[]"]');

    function validarTexto(input) {
        const value = input.value.trim();
        if (value.length < 3) {
            input.classList.add('is-invalid');
            return false;
        } else {
            input.classList.remove('is-invalid');
            return true;
        }
    }

    function validarEmail(input) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!regex.test(input.value)) {
            input.classList.add('is-invalid');
            return false;
        } else {
            input.classList.remove('is-invalid');
            return true;
        }
    }

    function validarGrupos(select) {
        if (select.selectedOptions.length === 0) {
            select.classList.add('is-invalid');
            return false;
        } else {
            select.classList.remove('is-invalid');
            return true;
        }
    }

    if (nombre) nombre.addEventListener('input', () => validarTexto(nombre));
    if (area) area.addEventListener('input', () => validarTexto(area));
    if (correo) correo.addEventListener('input', () => validarEmail(correo));
    if (grupos) grupos.addEventListener('change', () => validarGrupos(grupos));
    
    // Validación inicial si hay valores guardados
    if (nombre && nombre.value) validarTexto(nombre);
    if (area && area.value) validarTexto(area);
    if (correo && correo.value) validarEmail(correo);
    if (grupos && grupos.selectedOptions.length > 0) validarGrupos(grupos);
});
</script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Éxito',
    text: '{{ session('success') }}',
    timer: 2000,
    showConfirmButton: false
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Oops...',
    text: '{{ session('error') }}'
});
</script>
@endif

@endsection