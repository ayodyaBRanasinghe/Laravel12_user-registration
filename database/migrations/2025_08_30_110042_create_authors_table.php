<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('research_id'); // match parent ID type
            $table->string('f_name');
            $table->string('l_name');
            $table->string('email');
            $table->string('altr_email')->nullable();
            $table->string('mobile');
            $table->string('affinition');
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint
            $table->foreign('research_id')
                  ->references('id')
                  ->on('researches')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
