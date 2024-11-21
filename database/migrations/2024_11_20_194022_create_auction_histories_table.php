<?php

use App\Models\Auction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('auction_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Auction::class);
            $table->foreignIdFor(User::class);
            $table->integer('bid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auction_histories');
    }
};
