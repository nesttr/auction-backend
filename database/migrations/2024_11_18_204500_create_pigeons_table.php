<?php

use App\Models\User;
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
        Schema::create('pigeons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->string('code');
            $table->string('mother_name');
            $table->string('father_name');
            $table->string('color');
            $table->string('size');
            $table->enum('rating', [1,2,3,4,5]);
            $table->boolean('sex')->default(false); // 0 = male , 1 = female
            $table->boolean('sold')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pigeons');
    }
};
