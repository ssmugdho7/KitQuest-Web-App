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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            $table->string('name',100);   
            $table->string('price',50);
            $table->string('unit',10)->default('1');
            $table->string('img_url',200);
            $table->boolean('discount',50)->default(0);
            $table->string('discount_price',50);
            $table->boolean('stock',50);
            $table->float('star',50);
            $table->enum('remark', ['New', 'Trending', 'Featured', 'Best Seller']);
            
    
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')
            ->cascadeOnDelete()
            ->cascadeOnUpdate();
            
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
