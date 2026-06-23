@extends('layouts.app')

@section('title', 'Ayuda | InventoryPro')
@section('page_title', 'Centro de Ayuda')
@section('page_subtitle', 'Manual de usuario, preguntas frecuentes y guías de uso')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="github-panel p-4">
            <h2 class="h5 mb-4 text-primary"><i class="bi bi-book me-2"></i>Manual de Usuario Rápido</h2>
            
            <div class="accordion" id="helpAccordion">
                
                <div class="accordion-item bg-dark text-light border-secondary">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed bg-dark text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            <i class="bi bi-boxes me-2 text-success"></i> Módulo de Productos
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#helpAccordion">
                        <div class="accordion-body">
                            <strong>Gestión de Catálogo:</strong> En este módulo puedes registrar todos los ítems de tu almacén. Necesitarás especificar un SKU único, el nombre, asignar una categoría y un proveedor. El sistema calculará el stock en base a los movimientos registrados.
                        </div>
                    </div>
                </div>

                <div class="accordion-item bg-dark text-light border-secondary">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed bg-dark text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <i class="bi bi-arrow-left-right me-2 text-info"></i> Módulo de Movimientos
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#helpAccordion">
                        <div class="accordion-body">
                            <strong>Entradas y Salidas:</strong> Para modificar el stock de un producto no puedes editar el número directamente. Debes registrar un <code>Movimiento</code> seleccionando el tipo (Compra, Reabastecimiento, Venta, Merma). El sistema sumará o restará la cantidad especificada de forma automática y segura.
                        </div>
                    </div>
                </div>

                <div class="accordion-item bg-dark text-light border-secondary">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed bg-dark text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <i class="bi bi-graph-up-arrow me-2 text-warning"></i> Reportes y Auditoría
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#helpAccordion">
                        <div class="accordion-body">
                            <strong>Análisis de Datos:</strong> El módulo de reportes te muestra información procesada en tiempo real. Ahora puedes exportar estos reportes en formatos <code>PDF</code> o <code>Excel</code> mediante los botones habilitados en la esquina superior de cada tarjeta.<br><br>
                            Los administradores tienen acceso al panel de <strong>Logs de Seguridad</strong> para auditar todas las operaciones críticas.
                        </div>
                    </div>
                </div>

                <div class="accordion-item bg-dark text-light border-secondary">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed bg-dark text-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <i class="bi bi-question-circle me-2 text-danger"></i> Preguntas Frecuentes (FAQ)
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#helpAccordion">
                        <div class="accordion-body">
                            <ul>
                                <li><strong>¿Por qué un producto aparece marcado en rojo en el listado?</strong> Significa que su stock actual ha llegado a 0 (Agotado).</li>
                                <li><strong>¿Cómo cambio la contraseña de un usuario?</strong> Debes contactar a un Administrador del sistema; ellos pueden modificar las credenciales en el módulo Usuarios.</li>
                                <li><strong>¿Puedo eliminar un movimiento por error?</strong> Las transacciones consolidadas bloquean el stock físico. Consulta con gerencia para asentar una operación de corrección o merma inversa.</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .accordion-button::after {
        filter: invert(1);
    }
    .accordion-button:not(.collapsed) {
        background-color: #21262D;
        color: #F0F6FC;
        box-shadow: inset 0 -1px 0 rgba(255,255,255,0.1);
    }
</style>
@endsection
