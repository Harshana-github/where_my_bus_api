<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToTownsTable extends Migration
{
    public function up()
    {
        Schema::table('towns', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('name');
        });
    }

    public function down()
    {
        Schema::table('towns', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
}
