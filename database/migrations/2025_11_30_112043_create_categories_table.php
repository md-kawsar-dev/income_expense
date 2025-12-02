<?php

use App\Enums\CategoryEnum;
use App\Models\Category;
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
            $table->enum('category_type', [
                CategoryEnum::NEED->value,
                CategoryEnum::WANT->value,
                CategoryEnum::SAVINGS->value,
            ]);
            $table->string('category_name');
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
