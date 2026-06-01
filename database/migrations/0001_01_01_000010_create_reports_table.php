<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->string('type', 100);
            $table->string('title')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->index('user_id');

            $table->foreign('user_id', 'reports_user_id_foreign')
                ->references('id')
                ->on('users')
                ->onDelete('set null');


            $table->json('payload')->nullable();
            $table->timestamps();

            $table->index(['type', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};



