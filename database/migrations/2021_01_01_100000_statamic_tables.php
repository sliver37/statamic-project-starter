<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StatamicTables extends Migration
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

            $table->boolean('super')->after('remember_token')->default(false)->index();
            $table->string('avatar')->after('super')->nullable();
            $table->json('preferences')->after('avatar')->nullable();
            $table->timestamp('last_login')->after('preferences')->nullable();
            $table->string('password')->nullable()->change();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('role_id')->index();
        });

        Schema::create('group_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('group_id')->index();
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->string('notifiable_id')->change();

            $table->index('read_at');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->string('user_id')->nullable()->change();
        });

        Schema::table('cache', function (Blueprint $table) {
            $table->index('expiration');
        });

        Schema::table('failed_jobs', function (Blueprint $table) {
            $table->index('queue');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();

            $table->dropColumn('super');
            $table->dropColumn('avatar');
            $table->dropColumn('preferences');
            $table->dropColumn('last_login');
            $table->string('password')->nullable(false)->change();
        });

        Schema::dropIfExists('role_user');
        Schema::dropIfExists('group_user');

        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('notifiable_id')->change();

            $table->dropIndex('read_at');
        });

        Schema::table('sessions', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->change();
        });

        Schema::table('cache', function (Blueprint $table) {
            $table->dropIndex('expiration');
        });

        Schema::table('failed_jobs', function (Blueprint $table) {
            $table->dropIndex('queue');
        });
    }
}
