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
        Schema::create('admin__accesses', function (Blueprint $table) {
            $table->id();
            $table->string('key', 15);
            $table->string('name', 50);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });

        DB::table('admin__accesses')
            ->insert([
                ['key' => 'CREATE', 'name' => 'Создание'],
                ['key' => 'READ', 'name' => 'Просмотр'],
                ['key' => 'UPDATE', 'name' => 'Изменение'],
                ['key' => 'DELETE', 'name' => 'Удаление'],
                ['key' => 'USER_CREATE', 'name' => 'Создание пользователей'],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin__accesses');
    }
};
