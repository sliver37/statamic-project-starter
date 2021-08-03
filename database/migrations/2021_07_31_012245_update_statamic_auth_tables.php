<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatamicAuthTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('id')->change();

            $table->index('super');
        });

        Schema::table('role_user', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('role_id');
        });

        Schema::table('group_user', function (Blueprint $table) {
            $table->index('user_id');
            $table->index('group_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();

            $table->dropIndex('super');
        });

        Schema::table('role_user', function (Blueprint $table) {
            $table->dropIndex('user_id');
            $table->dropIndex('role_id');
        });

        Schema::table('group_user', function (Blueprint $table) {
            $table->dropIndex('user_id');
            $table->dropIndex('group_id');
        });
    }
}
