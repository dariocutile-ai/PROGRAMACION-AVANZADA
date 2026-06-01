<?php

namespace App\Providers;

use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CommentRepositoryInterface;
use App\Interfaces\InventoryMovementRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\SupplierRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentRepository;
use App\Repositories\InventoryMovementRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SupplierRepository;
use App\Models\Category;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Report;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\InventoryMovementPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ReportPolicy;
use App\Policies\RolePolicy;
use App\Policies\SupplierPolicy;
use App\Policies\UserPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(SupplierRepositoryInterface::class, SupplierRepository::class);
        $this->app->bind(InventoryMovementRepositoryInterface::class, InventoryMovementRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Supplier::class, SupplierPolicy::class);
        Gate::policy(InventoryMovement::class, InventoryMovementPolicy::class);
        Gate::policy(Report::class, ReportPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Role::class, RolePolicy::class);
    }
}
