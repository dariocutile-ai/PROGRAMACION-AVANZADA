InventoryPro - progreso

- Foundation implementada:
  - Auth API real con Sanctum: /api/v1/auth/{register,login,logout}
  - Middleware RBAC: CheckRoleMiddleware (Admin/Manager/Employee)
  - Model RBAC: User::roles() (belongsToMany)

- CRUD API Products (arquitectura limpia):
  - routes: /api/v1/products (resource)
  - Controller: app/Http/Controllers/Api/V1/ProductsController.php
  - Service: app/Services/Products/ProductService.php
  - Requests: StoreProductRequest, UpdateProductRequest
  - Resources: ProductResource, ProductResourceCollection

Verificado:
- php artisan route:list ✅
- php artisan test ✅

