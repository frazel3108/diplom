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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->default(0);
            $table->string('name');
            $table->string('url')->unique();
            $table->string('image')->nullable()->default(null);
            $table->integer('order')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        // DB::table('categories')
        //     ->insert([
        //         ['parent_id' => 0, 'name' => 'Ключи и пин-коды', 'url' => 'kliuci-i-pin-kody'],
        //         ['parent_id' => 0, 'name' => 'Программное обеспечение', 'url' => 'programmnoe-obespecenie'],
        //         ['parent_id' => 0, 'name' => 'Цифровые товары', 'url' => 'cifrovye-tovary'],
        //         ['parent_id' => 0, 'name' => 'Электронные книги', 'url' => 'new-elektronnye-knigi'],
        //         ['parent_id' => 0, 'name' => 'Интернет провайдеры', 'url' => 'internet-provaidery'],
        //         ['parent_id' => 1, 'name' => 'Игры', 'url' => 'games'],
        //     ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};