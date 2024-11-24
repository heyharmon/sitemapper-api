<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->string('domain')->nullable();
            $table->string('url')->nullable();
            $table->integer('rank')->nullable();
            $table->integer('design_rating')->nullable();
            // $table->string('screenshot_url')->nullable();
            // $table->foreignId('screenshot_file_id')->nullable();
            // $table->foreignId('favicon_file_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['rank', 'design_rating']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('websites');
    }
};
