<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToBusesTable extends Migration
{
    public function up()
    {
        Schema::table('buses', function (Blueprint $table) {
            $table->string('image_01')->nullable()->after('registration_id');
            $table->boolean('is_active')->default(true)->after('image_01');
            $table->boolean('is_filed')->default(false)->after('is_active');
        });
    }

    public function down()
    {
        Schema::table('buses', function (Blueprint $table) {
            $table->dropColumn(['image_01', 'is_active', 'is_filed']);
        });
    }
}
