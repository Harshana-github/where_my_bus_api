<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAiPredictionsTable extends Migration
{
    public function up()
    {
        Schema::create('ai_predictions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bus_id')->constrained('buses')->onDelete('cascade');
            $table->decimal('predicted_arrival_time', 8, 2);
            $table->decimal('distance', 8, 2);
            $table->decimal('speed', 8, 2);
            $table->string('traffic_condition');
            $table->timestamp('prediction_timestamp')->useCurrent(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ai_predictions');
    }
}
