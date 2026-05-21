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
        Schema::create('properties', function (Blueprint $table) {
          $table->id();

            $table->string('title');
            $table->string('slug')->unique();

            $table->bigInteger('price');

            $table->string('location');
            $table->string('city')->default('Bandung');

            $table->enum('type', ['rumah', 'tanah', 'apartemen']);
            $table->enum('listing_type', ['primary', 'secondary']);

            $table->integer('bedroom')->nullable();
            $table->integer('bathroom')->nullable();

            $table->integer('land_size')->nullable(); // m²
            $table->integer('building_size')->nullable(); // m²

            $table->text('description')->nullable();
            $table->text('address')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->boolean('is_featured')->default(false);

            // future ready
            $table->string('phone')->nullable();

            $table->timestamps();

            $table->index('city');
            $table->index('price');
            $table->index('type');
            $table->index('listing_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
