<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('location')->nullable();
            $table->enum('category', [
                'workshop',
                'seminar',
                'training',
                'conference',
                'competition',
                'exhibition',
                'other',
            ])->default('other');
            $table->string('organizer')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['draft', 'published', 'cancelled', 'completed'])
                ->default('draft');
            $table->integer('max_participants')->nullable();
            $table->dateTime('registration_deadline')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better query performance
            $table->index('start_date');
            $table->index('status');
            $table->index('category');
            $table->index(['start_date', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
