<?php

use App\Models\Pigeon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pigeon_images', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Pigeon::class);
            $table->string('path');
            $table->boolean('family_tree')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pigeon_images');
    }
};
