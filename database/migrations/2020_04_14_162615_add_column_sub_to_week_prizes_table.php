<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnSubToWeekPrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('member_exams', function (Blueprint $table) {
            if (! Schema::hasColumn('member_exams', 'sub')) {
                $table->integer('sub')->nullable();
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
        Schema::table('member_exams', function (Blueprint $table) {
            if (Schema::hasColumn('member_exams', 'sub')) {
                $table->dropColumn('sub');
            }
        });
    }
}
