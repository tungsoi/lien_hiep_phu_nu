<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnToWeeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weeks', function (Blueprint $table) {
            if (! Schema::hasColumn('weeks', 'status')) {
                $table->integer('status')->default(0)->comment('0: chua dien ra, 1: dang dien ra, 2: da ket thuc');
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
        Schema::table('weeks', function (Blueprint $table) {
            if (Schema::hasColumn('weeks', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
}
