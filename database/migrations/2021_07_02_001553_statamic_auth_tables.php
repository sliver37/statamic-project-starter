<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StatamicAuthTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add new columns
            $table->boolean('super')->default(false)->index();
            $table->string('avatar')->nullable();
            $table->json('preferences')->nullable();
            $table->timestamp('last_login')->nullable();

            // Update existing columns
            $table->string('id')->change();
            $table->string('password')->nullable()->change();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->index();
            $table->string('role_id')->index();
        });

        Schema::create('group_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->index();
            $table->string('group_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('super');
            $table->dropColumn('avatar');
            $table->dropColumn('preferences');
            $table->dropColumn('last_login');
            $table->string('password')->nullable(false)->change();
        });

        Schema::dropIfExists('role_user');
        Schema::dropIfExists('group_user');
    }
}
