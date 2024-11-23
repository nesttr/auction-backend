<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('automatic_bids', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Auction::class)->index();
            $table->foreignIdFor(User::class)->index();
            $table->integer('bid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('automatic_bids');
    }
};
