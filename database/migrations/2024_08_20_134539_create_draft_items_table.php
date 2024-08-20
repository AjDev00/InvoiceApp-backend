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
        Schema::create('draft_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('draft_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string("item_name");
            $table->string("quantity");
            $table->string("price");
            $table->string("total");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('draft_items');
    }
};
