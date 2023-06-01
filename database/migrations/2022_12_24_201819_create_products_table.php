<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('old_id')->default(0);
            $table->integer('category_id')->default(0);
            $table->string('name');
            $table->string('url')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2, true)->default(0);
            $table->decimal('sale_price', 10, 2, true)->default(0);
            $table->json('images')->nullable();
            $table->boolean('popular')->default(false);
            $table->integer('order')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};