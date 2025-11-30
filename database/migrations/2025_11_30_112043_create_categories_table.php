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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scope_id');
            $table->string('en');
            $table->string('bn');
            $table->decimal('amount')->default(0);
            $table->timestamps();
            $table->softDeletes();
            // foreign key scope_id by users table
            $table->foreign('scope_id')->references('id')->on('users')->onDelete('cascade');
            // index 
            $table->index('scope_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
