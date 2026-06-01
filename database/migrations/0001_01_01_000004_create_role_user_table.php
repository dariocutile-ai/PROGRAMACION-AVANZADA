<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');

            // Índices
            $table->index('role_id');
            $table->index('user_id');

            // Constraints con nombres explícitos (evita el error Duplicate key name '1')
            $table->foreign('role_id', 'role_user_role_id_foreign')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->foreign('user_id', 'role_user_user_id_foreign')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['role_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_user');
    }
};


