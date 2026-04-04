@extends('layouts.coordinador')

@section('content')
<div class="container-fluid px-4">
    
    <!-- Header con estadísticas -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-bar-chart-steps me-2 text-primary"></i>Reporte de tutorías
            </h2>
            <p class="text-muted">Análisis general de tutorías por alumno y grupo</p>
        </div>
        <div class="text-end">
            <div class="dropdown">
                <button class="btn btn-light rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-download me-1"></i> Exportar
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                    <li><a class="dropdown-item" href="#" id="exportPDFBtn"><i class="bi bi-file-pdf me-2 text-danger"></i>PDF</a></li>
                    <li><a class="dropdown-item" href="#" id="exportExcelBtn"><i class="bi bi-file-excel me-2 text-success"></i>Excel</a></li>
                    <li><a class="dropdown-item" href="#" id="printBtn"><i class="bi bi-printer me-2"></i>Imprimir</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Tarjeta de total general -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm hover-shadow transition" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Total de tutorías</div>
                            <h2 class="fw-bold display-4 mb-0">{{ $totalTutorias }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-calendar-check-fill text-primary fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-people me-1"></i> Sesiones registradas en el sistema
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm hover-shadow transition" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Alumnos con tutorías</div>
                            <h2 class="fw-bold display-4 mb-0">{{ $alumnos->where('tutorias_count', '>', 0)->count() }}</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-mortarboard-fill text-success fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-check-circle me-1"></i> Alumnos que han recibido tutorías
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm hover-shadow transition" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted small text-uppercase fw-semibold mb-2">Promedio por alumno</div>
                            <h2 class="fw-bold display-4 mb-0">{{ number_format($alumnos->avg('tutorias_count'), 1) }}</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-graph-up text-info fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-bar-chart me-1"></i> Tutorías promedio por estudiante
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de reporte mejorada -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-table me-2 text-primary"></i>Detalle de tutorías por alumno
                </h5>
                <div class="d-flex gap-2">
                    <div class="input-group" style="width: 250px;">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="searchInput" class="form-control border-start-0 rounded-end-pill" placeholder="Buscar alumno...">
                    </div>
                    <select id="filterGroup" class="form-select rounded-pill" style="width: 150px;">
                        <option value="">Todos los grupos</option>
                        @php
                            $grupos = $alumnos->pluck('grupo')->unique();
                        @endphp
                        @foreach($grupos as $grupo)
                            @if($grupo)
                                <option value="{{ is_object($grupo) ? $grupo->nombre : $grupo }}">{{ is_object($grupo) ? $grupo->nombre : $grupo }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($alumnos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="reporteTable">
                        <thead class="bg-light">
                            <tr class="border-0">
                                <th class="px-4 py-3 border-0">
                                    <i class="bi bi-person me-1"></i> Alumno
                                </th>
                                <th class="py-3 border-0">
                                    <i class="bi bi-people me-1"></i> Grupo
                                </th>
                                <th class="py-3 border-0">
                                    <i class="bi bi-book me-1"></i> Matrícula
                                </th>
                                <th class="py-3 border-0 text-center">
                                    <i class="bi bi-calendar-check me-1"></i> Tutorías
                                </th>
                                <th class="py-3 border-0 text-center">
                                    <i class="bi bi-star me-1"></i> Progreso
                                </th>
                                <th class="px-4 py-3 border-0 text-center">Acciones</th>
                             </tr>
                        </thead>
                        <tbody>
                            @foreach($alumnos as $alumno)
                            @php
                                $nombreAlumno = strtolower($alumno->user->name ?? '');
                                $grupoNombre = is_object($alumno->grupo) ? $alumno->grupo->nombre : $alumno->grupo;
                            @endphp
                            <tr class="border-bottom" 
                                data-nombre="{{ $nombreAlumno }}" 
                                data-grupo="{{ $grupoNombre ?? '' }}">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle bg-info bg-opacity-10 rounded-circle p-2" style="width: 36px; height: 36px;">
                                            <i class="bi bi-person-circle text-info"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">
                                                <a href="{{ route('coordinador.alumnos.show', $alumno->id) }}" class="text-decoration-none text-dark hover-primary">
                                                    {{ $alumno->user->name ?? 'Sin nombre' }}
                                                </a>
                                            </div>
                                            <small class="text-muted">{{ $alumno->user->email ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                                        <i class="bi bi-people-fill me-1"></i> {{ $grupoNombre ?? 'Sin grupo' }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <code>{{ $alumno->matricula ?? 'N/A' }}</code>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="badge {{ $alumno->tutorias_count > 0 ? 'bg-success' : 'bg-secondary' }} rounded-pill px-3 py-2 fs-6">
                                        <i class="bi bi-check-circle-fill me-1"></i> {{ $alumno->tutorias_count }}
                                    </span>
                                </td>
                                <td class="py-3 text-center" style="min-width: 120px;">
                                    @php
                                        $maxTutorias = max($alumnos->max('tutorias_count'), 1);
                                        $porcentaje = min(($alumno->tutorias_count / $maxTutorias) * 100, 100);
                                    @endphp
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="progress flex-grow-1" style="height: 6px;">
                                            <div class="progress-bar bg-{{ $alumno->tutorias_count > 0 ? 'success' : 'secondary' }}" 
                                                 style="width: {{ $porcentaje }}%"></div>
                                        </div>
                                        <small class="text-muted">{{ round($porcentaje) }}%</small>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('coordinador.alumnos.show', $alumno->id) }}" 
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                       data-bs-toggle="tooltip" 
                                       title="Ver detalles del alumno">
                                        <i class="bi bi-eye me-1"></i> Ver
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginación -->
                @if(method_exists($alumnos, 'links'))
                    <div class="d-flex justify-content-center p-4">
                        {{ $alumnos->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state m-4">
                    <i class="bi bi-inbox display-1 text-muted mb-3 d-block"></i>
                    <h5 class="text-muted">No hay datos para mostrar</h5>
                    <p class="text-muted mb-0">No se encontraron registros de tutorías</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Sección de estadísticas adicionales -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-pie-chart me-2 text-primary"></i>Tutorías por grupo
                    </h5>
                </div>
                <div class="card-body p-4">
                    @php
                        $tutoriasPorGrupo = $alumnos->groupBy(function($alumno) {
                            return is_object($alumno->grupo) ? $alumno->grupo->nombre : $alumno->grupo;
                        })->map(function($grupo) {
                            return $grupo->sum('tutorias_count');
                        });
                    @endphp
                    
                    @if($tutoriasPorGrupo->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                    @foreach($tutoriasPorGrupo as $grupo => $total)
                                    <tr>
                                        <td><strong>{{ $grupo ?? 'Sin grupo' }}</strong></td>
                                        <td class="text-end">
                                            <span class="badge bg-primary rounded-pill px-3 py-2">{{ $total }} tutorías</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-3">
                            <small class="text-muted">No hay datos disponibles</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-trophy me-2 text-primary"></i>Alumnos con más tutorías
                    </h5>
                </div>
                <div class="card-body p-4">
                    @php
                        $topAlumnos = $alumnos->sortByDesc('tutorias_count')->take(5);
                    @endphp
                    
                    @if($topAlumnos->count() > 0 && $topAlumnos->sum('tutorias_count') > 0)
                        @foreach($topAlumnos as $index => $alumno)
                            @if($alumno->tutorias_count > 0)
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <span class="fw-bold text-primary">{{ $index + 1 }}</span>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold">{{ $alumno->user->name ?? 'Sin nombre' }}</div>
                                    <small class="text-muted">{{ is_object($alumno->grupo) ? $alumno->grupo->nombre : $alumno->grupo }}</small>
                                </div>
                                <span class="badge bg-success rounded-pill px-3 py-2">{{ $alumno->tutorias_count }} tutorías</span>
                            </div>
                            @endif
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <i class="bi bi-emoji-smile display-4 text-muted"></i>
                            <p class="text-muted mt-2">Aún no hay tutorías registradas</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-primary:hover {
        color: #3b82f6 !important;
    }
    
    .progress-bar {
        transition: width 0.3s ease;
    }
    
    .table tbody tr {
        transition: background-color 0.2s ease;
    }
    
    .table tbody tr:hover {
        background-color: #f8fafc;
    }
    
    .avatar-circle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
    }
    
    .transition {
        transition: all 0.3s ease;
    }
    
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
    
    @media print {
        .btn, .dropdown, .navbar-custom, .sidebar, .no-print {
            display: none !important;
        }
        
        .main-content {
            margin-left: 0 !important;
            width: 100% !important;
        }
        
        .card {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Obtener elementos del DOM
    const searchInput = document.getElementById('searchInput');
    const filterGroup = document.getElementById('filterGroup');
    const table = document.getElementById('reporteTable');
    
    // Función para filtrar la tabla
    function filterTable() {
        if (!table) return;
        
        const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const groupFilter = filterGroup ? filterGroup.value : '';
        
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
        
        const rows = tbody.querySelectorAll('tr');
        
        rows.forEach(row => {
            const nombre = row.getAttribute('data-nombre') || '';
            const grupo = row.getAttribute('data-grupo') || '';
            
            const matchesSearch = searchTerm === '' || nombre.includes(searchTerm);
            const matchesGroup = groupFilter === '' || grupo === groupFilter;
            
            row.style.display = matchesSearch && matchesGroup ? '' : 'none';
        });
    }
    
    // Agregar event listeners
    if (searchInput) {
        searchInput.addEventListener('keyup', filterTable);
    }
    
    if (filterGroup) {
        filterGroup.addEventListener('change', filterTable);
    }
    
    filterTable();
    
    // ==================== FUNCIONES DE EXPORTACIÓN ====================
    
    // 1. Exportar a Excel
    document.getElementById('exportExcelBtn').addEventListener('click', function(e) {
        e.preventDefault();
        
        // Obtener solo las filas visibles
        const tbody = table.querySelector('tbody');
        const visibleRows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.style.display !== 'none');
        
        // Crear datos para Excel
        const excelData = [];
        
        // Encabezados
        excelData.push(['Alumno', 'Grupo', 'Matrícula', 'Tutorías', 'Progreso (%)']);
        
        // Datos de las filas visibles
        visibleRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length >= 5) {
                const nombre = cells[0].querySelector('.fw-semibold a')?.innerText || cells[0].querySelector('.fw-semibold')?.innerText || '';
                const grupo = cells[1].innerText.replace(/[^\w\sáéíóúñ]/g, '').trim();
                const matricula = cells[2].innerText;
                const tutorias = cells[3].innerText.match(/\d+/)?.[0] || '0';
                const progreso = cells[4].querySelector('small')?.innerText?.replace('%', '') || '0';
                
                excelData.push([nombre, grupo, matricula, tutorias, progreso]);
            }
        });
        
        // Crear hoja de trabajo
        const ws = XLSX.utils.aoa_to_sheet(excelData);
        
        // Ajustar ancho de columnas
        ws['!cols'] = [
            {wch: 30}, // Alumno
            {wch: 15}, // Grupo
            {wch: 15}, // Matrícula
            {wch: 10}, // Tutorías
            {wch: 12}  // Progreso
        ];
        
        // Crear libro y descargar
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Reporte_Tutorias');
        
        // Generar nombre de archivo con fecha
        const fecha = new Date();
        const fechaStr = `${fecha.getFullYear()}-${(fecha.getMonth()+1).toString().padStart(2,'0')}-${fecha.getDate().toString().padStart(2,'0')}`;
        XLSX.writeFile(wb, `reporte_tutorias_${fechaStr}.xlsx`);
        
        // SweetAlert de éxito
        Swal.fire({
            icon: 'success',
            title: 'Exportado',
            text: 'El archivo Excel se ha generado correctamente',
            timer: 2000,
            showConfirmButton: false
        });
    });
    
    // 2. Exportar a PDF
    document.getElementById('exportPDFBtn').addEventListener('click', function(e) {
        e.preventDefault();
        
        // Crear un elemento contenedor para el PDF
        const elementToExport = document.createElement('div');
        
        // Obtener las filas visibles
        const tbody = table.querySelector('tbody');
        const visibleRows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.style.display !== 'none');
        
        // Construir HTML para el PDF
        elementToExport.innerHTML = `
            <div style="font-family: Arial, sans-serif; padding: 20px;">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="color: #3b82f6;">Sistema de Tutorías</h1>
                    <h2>Reporte de Tutorías por Alumno</h2>
                    <p>Fecha de generación: ${new Date().toLocaleDateString('es-ES')}</p>
                    <hr>
                </div>
                
                <div style="margin-bottom: 20px;">
                    <p><strong>Total de tutorías:</strong> {{ $totalTutorias }}</p>
                    <p><strong>Alumnos con tutorías:</strong> {{ $alumnos->where('tutorias_count', '>', 0)->count() }}</p>
                    <p><strong>Promedio por alumno:</strong> {{ number_format($alumnos->avg('tutorias_count'), 1) }}</p>
                </div>
                
                <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                    <thead>
                        <tr style="background-color: #3b82f6; color: white;">
                            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Alumno</th>
                            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Grupo</th>
                            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Matrícula</th>
                            <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Tutorías</th>
                            <th style="padding: 10px; border: 1px solid #ddd; text-align: center;">Progreso</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        visibleRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length >= 5) {
                const nombre = cells[0].querySelector('.fw-semibold a')?.innerText || cells[0].querySelector('.fw-semibold')?.innerText || '';
                const grupo = cells[1].innerText.replace(/[^\w\sáéíóúñ]/g, '').trim();
                const matricula = cells[2].innerText;
                const tutorias = cells[3].innerText.match(/\d+/)?.[0] || '0';
                const progreso = cells[4].querySelector('small')?.innerText || '0%';
                
                elementToExport.innerHTML += `
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd;">${nombre}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${grupo}</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">${matricula}</td>
                        <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">${tutorias}</td>
                        <td style="padding: 8px; border: 1px solid #ddd; text-align: center;">${progreso}</td>
                    </tr>
                `;
            }
        });
        
        elementToExport.innerHTML += `
                    </tbody>
                </table>
                
                <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #666;">
                    <hr>
                    <p>Reporte generado automáticamente por el Sistema de Tutorías</p>
                </div>
            </div>
        `;
        
        // Configurar opciones del PDF
        const opt = {
            margin:        [0.5, 0.5, 0.5, 0.5],
            filename:     `reporte_tutorias_${new Date().toISOString().slice(0,10)}.pdf`,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, letterRendering: true },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'landscape' }
        };
        
        // Generar PDF
        html2pdf().set(opt).from(elementToExport).save();
        
        // SweetAlert de éxito
        Swal.fire({
            icon: 'success',
            title: 'Generando PDF',
            text: 'El archivo PDF se está generando...',
            timer: 2000,
            showConfirmButton: false
        });
    });
    
    // 3. Imprimir
    document.getElementById('printBtn').addEventListener('click', function(e) {
        e.preventDefault();
        
        // Obtener las filas visibles
        const tbody = table.querySelector('tbody');
        const visibleRows = Array.from(tbody.querySelectorAll('tr')).filter(row => row.style.display !== 'none');
        
        // Construir contenido para impresión
        const printContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Reporte de Tutorías</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        padding: 20px;
                    }
                    h1 {
                        color: #3b82f6;
                        text-align: center;
                    }
                    h2 {
                        text-align: center;
                        margin-bottom: 20px;
                    }
                    .info {
                        margin-bottom: 20px;
                        padding: 10px;
                        background-color: #f8f9fa;
                        border-radius: 5px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: left;
                    }
                    th {
                        background-color: #3b82f6;
                        color: white;
                    }
                    .text-center {
                        text-align: center;
                    }
                    .footer {
                        margin-top: 30px;
                        text-align: center;
                        font-size: 12px;
                        color: #666;
                    }
                    @media print {
                        .no-print {
                            display: none;
                        }
                    }
                </style>
            </head>
            <body>
                <h1>Sistema de Tutorías</h1>
                <h2>Reporte de Tutorías por Alumno</h2>
                
                <div class="info">
                    <p><strong>Fecha de impresión:</strong> ${new Date().toLocaleString('es-ES')}</p>
                    <p><strong>Total de tutorías:</strong> {{ $totalTutorias }}</p>
                    <p><strong>Alumnos con tutorías:</strong> {{ $alumnos->where('tutorias_count', '>', 0)->count() }}</p>
                    <p><strong>Promedio por alumno:</strong> {{ number_format($alumnos->avg('tutorias_count'), 1) }}</p>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Grupo</th>
                            <th>Matrícula</th>
                            <th class="text-center">Tutorías</th>
                            <th class="text-center">Progreso</th>
                        </tr>
                    </thead>
                    <tbody>
        `;
        
        visibleRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length >= 5) {
                const nombre = cells[0].querySelector('.fw-semibold a')?.innerText || cells[0].querySelector('.fw-semibold')?.innerText || '';
                const grupo = cells[1].innerText.replace(/[^\w\sáéíóúñ]/g, '').trim();
                const matricula = cells[2].innerText;
                const tutorias = cells[3].innerText.match(/\d+/)?.[0] || '0';
                const progreso = cells[4].querySelector('small')?.innerText || '0%';
                
                printContent += `
                    <tr>
                        <td>${nombre}</td>
                        <td>${grupo}</td>
                        <td>${matricula}</td>
                        <td class="text-center">${tutorias}</td>
                        <td class="text-center">${progreso}</td>
                    </tr>
                `;
            }
        });
        
        printContent += `
                    </tbody>
                </table>
                
                <div class="footer">
                    <hr>
                    <p>Reporte generado automáticamente por el Sistema de Tutorías</p>
                </div>
                
                <script>
                    window.onload = function() {
                        window.print();
                        setTimeout(function() {
                            window.close();
                        }, 500);
                    };
                <\/script>
            </body>
            </html>
        `;
        
        // Abrir ventana de impresión
        const printWindow = window.open('', '_blank');
        printWindow.document.write(printContent);
        printWindow.document.close();
        
        // SweetAlert de éxito
        Swal.fire({
            icon: 'info',
            title: 'Imprimiendo',
            text: 'Se abrirá una nueva ventana para imprimir el reporte',
            timer: 1500,
            showConfirmButton: false
        });
    });
});
</script>

@endsection