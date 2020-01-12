<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prizes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('content')->nullable();
            $table->integer('level')->default(4)->comment('1: giai nhat, 2: giai nhi, 3: giai ba, 4: khuyen khich');
            $table->integer('number')->default(0)->comment('So luong giai trong 1 tuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prizes');
    }
}
