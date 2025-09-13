<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('researches', function (Blueprint $table) {
            $table->id(); // unsignedBigInteger by default
            $table->string('title');
            $table->text('abstract');
            $table->string('keyword');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('researches');
    }
};
