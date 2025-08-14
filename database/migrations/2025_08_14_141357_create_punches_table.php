<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('punches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // created_at terá a data/hora do registro (com segundos)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('punches');
    }
};
