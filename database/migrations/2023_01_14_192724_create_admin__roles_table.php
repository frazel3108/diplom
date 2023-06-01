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
        Schema::create('admin__roles', function (Blueprint $table) {
            $table->id();
            $table->string('key', 50);
            $table->string('name', 50);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });

        DB::table('admin__roles')
            ->insert([
                ['key' => 'admin', 'name' => 'Администратор'],
                ['key' => 'moderator', 'name' => 'Модератор'],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin__roles');
    }
};
