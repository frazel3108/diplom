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
        Schema::create('admin__access_admin__role', function (Blueprint $table) {
            $table->id();
            $table->integer('admin__access_id');
            $table->integer('admin__role_id');
            $table->integer('level')->default(0);
            $table->json('info')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->nullable();
        });

        DB::table('admin__access_admin__role')
            ->insert([
                ['admin__access_id' => 1, 'admin__role_id' => 1, 'level' => 1, 'info' => null],
                ['admin__access_id' => 2, 'admin__role_id' => 1, 'level' => 1, 'info' => null],
                ['admin__access_id' => 3, 'admin__role_id' => 1, 'level' => 1, 'info' => null],
                ['admin__access_id' => 4, 'admin__role_id' => 1, 'level' => 1, 'info' => null],
                ['admin__access_id' => 5, 'admin__role_id' => 1, 'level' => 1, 'info' => null],
                ['admin__access_id' => 1, 'admin__role_id' => 2, 'level' => 0, 'info' => null],
                ['admin__access_id' => 2, 'admin__role_id' => 2, 'level' => 2, 'info' => json_encode(["App\\Models\\Admin\\User"])],
                ['admin__access_id' => 3, 'admin__role_id' => 2, 'level' => 2, 'info' => json_encode([])],
                ['admin__access_id' => 4, 'admin__role_id' => 2, 'level' => 0, 'info' => null],
                ['admin__access_id' => 5, 'admin__role_id' => 2, 'level' => 0, 'info' => null],
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin__access_admin__role');
    }
};
