<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnMobileToAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            if (! Schema::hasColumn('admin_users', 'mobile')) {
                $table->string('mobile')->nullable();
            }

            if (! Schema::hasColumn('admin_users', 'gender')) {
                $table->string('gender')->default(2)->comment('1: male, 0: female, 2: other');
            }

            if (! Schema::hasColumn('admin_users', 'birthday')) {
                $table->string('birthday')->nullable();
            }

            if (! Schema::hasColumn('admin_users', 'is_member')) {
                $table->string('is_member')->default(0);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            if (Schema::hasColumn('admin_users', 'mobile')) {
                $table->dropColumn('mobile');
            }

            if (Schema::hasColumn('admin_users', 'gender')) {
                $table->dropColumn('gender');
            }

            if (Schema::hasColumn('admin_users', 'birthday')) {
                $table->dropColumn('birthday');
            }

            if (Schema::hasColumn('admin_users', 'is_member')) {
                $table->dropColumn('is_member');
            }
        });
    }
}
