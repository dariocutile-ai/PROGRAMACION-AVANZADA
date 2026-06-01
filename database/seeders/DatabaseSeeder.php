<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Report;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        $owner = User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        $manager = User::updateOrCreate(
            ['email' => 'manager@example.com'],
            ['name' => 'Manager User', 'password' => bcrypt('password')]
        );

        $employee = User::updateOrCreate(
            ['email' => 'employee@example.com'],
            ['name' => 'Employee User', 'password' => bcrypt('password')]
        );

        // Roles
        $adminRole = Role::updateOrCreate(['name' => 'Admin'], ['description' => 'Admin access']);
        $managerRole = Role::updateOrCreate(['name' => 'Manager'], ['description' => 'Manager access']);
        $employeeRole = Role::updateOrCreate(['name' => 'Employee'], ['description' => 'Employee access']);

        $owner->roles()->sync([$adminRole->id]);
        $manager->roles()->sync([$managerRole->id]);
        $employee->roles()->sync([$employeeRole->id]);

        // Clean domain tables to keep deterministic seeding (incluye tablas con UNIQUE)
        // Truncates deben respetar el orden por FK.
        // Order: primero tablas hijas, luego padre.
        // Nota: en MySQL TRUNCATE falla si hay FK aunque la orden sea correcta.
        // Por eso usamos delete() para evitar el error.
        InventoryMovement::query()->delete();
        Comment::query()->delete();
        Report::query()->delete();
        Product::query()->delete();
        Category::query()->delete();
        Supplier::query()->delete();






        // Categories & suppliers
        // NOTE: categories.name es UNIQUE, por eso evitamos duplicados durante el seeding.
        $categories = collect();
        $target = 10;
        $safety = 0;

        while ($categories->count() < $target) {
            $safety++;
            if ($safety > 200) {
                throw new \RuntimeException('Seeder stuck while creating unique categories');
            }

            /** @var \App\Models\Category $candidate */
            $candidate = Category::factory()->make();
            $name = (string) ($candidate->name ?? '');

            if ($name === '') {
                continue;
            }

            // updateOrCreate evitará violaciones UNIQUE; pero además
            // evitamos insertar/desduplicar por ID en caso de colisiones.
            $persisted = Category::updateOrCreate(
                ['name' => $name],
                ['description' => (string) ($candidate->description ?? null)]
            );

            $categories->push($persisted);

            // paranoia: recorta el bucle si el UNIQUE no deja avanzar
            if ($categories->count() > $target * 3) {
                break;
            }

        }

        $categories = $categories->unique('id')->values();

        $suppliers = Supplier::factory()->count(10)->create();



        // Products
        $products = Product::factory()->count(25)->create();
        $products->each(function (Product $product) use ($categories, $suppliers) {
            $product->update([
                'category_id' => $categories->random()->id,
                'supplier_id' => $suppliers->random()->id,
            ]);
        });

        // Inventory movements (60)
        $users = User::all();
        $types = ['purchase', 'restock', 'sale', 'waste'];

        for ($i = 0; $i < 60; $i++) {
            $product = $products->random();
            $type = $types[array_rand($types)];

            InventoryMovement::create([
                'product_id' => $product->id,
                'user_id' => $users->random()->id,
                'type' => $type,
                'quantity' => random_int(1, 30),
                'unit_cost' => (string) $product->purchase_price,
                'reference_type' => null,
                'reference_id' => null,
                'note' => null,
            ]);
        }

        // Comments polymorphic (40)
        $commentUsers = User::all();
        $commentTargets = $products->concat($categories)->concat($suppliers)->values();

        for ($i = 0; $i < 40; $i++) {
            $target = $commentTargets->random();

            Comment::create([
                'user_id' => $commentUsers->random()->id,
                'commentable_id' => $target->id,
                'commentable_type' => $target::class,
                'content' => fake()->sentence(10),
            ]);
        }

        // Reports (10)
        $reportTypes = [
            'low_stock',
            'most_sold',
            'recent_movements',
            'inventory_summary',
            'category_stock',
        ];

        for ($i = 0; $i < 10; $i++) {
            Report::create([
                'type' => $reportTypes[array_rand($reportTypes)],
                'title' => 'Inventory Report',
                'user_id' => $owner->id,
                'payload' => ['generated_at' => now()->toDateTimeString()],
            ]);
        }
    }
}

