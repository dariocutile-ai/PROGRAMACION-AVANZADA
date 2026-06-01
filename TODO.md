# InventoryPro - TODO

## Fase 0 — Recolección de estado

- [x] Confirmar estructura existente del proyecto
- [x] Detectar que `routes/api.php` no existe
- [x] Revisar migraciones actuales y config relevante (auth/sanctum)

## Fase 1 — Arquitectura limpia + binding (pendiente)

- [ ] Crear/usar carpeta: app/DTOs, app/Helpers (si aplica)
- [ ] Registrar bindings en `AppServiceProvider`
    - Repositories via Interfaces

## Fase 2 — API base + manejo global de errores (pendiente)

- [ ] Estándar JSON global: `{ data, meta, errors }`
- [ ] 422/401/403/404/500 consistentes
- [ ] Paginación con `paginate()` donde aplique

## Fase 3 — DB + modelos (validación/pendiente)

- [ ] Revisar migraciones: FK, cascade, índices, soft deletes
- [ ] Modelos Eloquent con relaciones avanzadas + performance (with)
- [ ] Polymorphic comments: commentable_id/commentable_type

## Fase 4 — Auth + Sanctum (validación)

- [ ] Endpoints register/login/logout
- [ ] Tokens Sanctum protegidos

## Fase 5 — RBAC + middleware/policies (pendiente)

- [ ] Asegurar policies registradas y aplicadas
- [ ] Consistencia: middleware + policies + vistas

## Fase 6 — Inventario (validación/mejora)

- [ ] Compras/reposiciones (purchase/restock) => +stock
- [ ] Ventas/bajas (sale/waste) => -stock con validación
- [ ] Historial completo: inventory_movements

## Fase 7 — Reportes (validación/mejora)

- [ ] stock bajo
- [ ] productos más vendidos
- [ ] movimientos recientes
- [ ] inventario general
- [ ] reportes por categoría

## Fase 8 — Validaciones (pendiente)

- [ ] FormRequests: mensajes personalizados y reglas completas

## Fase 9 — Seeders/Factories (pendiente)

- [ ] Mínimo 50 registros coherentes y consistentes
- [ ] Ajustar stock si el modelo lo requiere

## Fase 10 — Tests (pendiente)

- [ ] Feature tests: auth, CRUD productos, permisos, validaciones, respuestas HTTP
- [ ] `php artisan test`

## Fase 11 — Documentación + Postman (pendiente)

- [ ] Documentación técnica completa
- [ ] Generar `postman_collection.json`

## Fase 12 — Frontend Blade integrado (pendiente)

- [ ] Dashboard con datos reales
- [ ] CRUD de productos/categorías/proveedores
- [ ] Vistas users/roles
- [ ] Reports panel
- [ ] UI responsive Bootstrap 5

## Fase 13 — QA final (pendiente)

- [ ] `php artisan migrate --seed`
- [ ] `php artisan test`
- [ ] `php artisan serve` y validar rutas
