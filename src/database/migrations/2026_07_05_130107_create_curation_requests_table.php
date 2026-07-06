<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curation_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('handled_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('status', ['pending', 'done'])->default('pending');

            $table->text('user_notes')->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamp('requested_at')->nullable();
            $table->timestamp('handled_at')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'status'], 'curation_user_status_idx');
            $table->index(['handled_by', 'status'], 'curation_admin_status_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curation_requests');
    }
};