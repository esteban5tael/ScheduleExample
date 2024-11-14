<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')->references('id')->on('users')->constrained()->cascadeOnUpdate()->cascadeOnDelete();

            $table->smallInteger('year');
            $table->smallInteger('month');
            $table->smallInteger('day');
            $table->smallInteger('dayofweek');
            $table->boolean('off')->default(false);
            $table->time('start');
            $table->time('end');
            $table->string('description')->nullable();
            $table->boolean('taken')->default(false);



            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
