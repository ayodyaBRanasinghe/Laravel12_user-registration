<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('research_id');
            $table->string('doc_path');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('research_id')
                  ->references('id')
                  ->on('researches')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
