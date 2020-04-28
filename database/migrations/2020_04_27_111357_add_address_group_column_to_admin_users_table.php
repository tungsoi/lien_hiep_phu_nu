<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressGroupColumnToAdminUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            if (! Schema::hasColumn('admin_users', 'province')) {
                $table->integer('province')->nullable();
            }

            if (! Schema::hasColumn('admin_users', 'district')) {
                $table->integer('district')->nullable();
            }

            if (! Schema::hasColumn('admin_users', 'address')) {
                $table->string('address')->nullable();
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
            if (Schema::hasColumn('admin_users', 'province')) {
                $table->dropColumn('province');
            }

            if (Schema::hasColumn('admin_users', 'district')) {
                $table->dropColumn('district');
            }

            if (Schema::hasColumn('admin_users', 'address')) {
                $table->dropColumn('address');
            }
        });
    }
}
