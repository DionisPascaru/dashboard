<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsImagesTable extends Migration
{
    public const PROJECTS_IMAGES_TABLE = 'projects_images';
    public const PROJECTS_TABLE = 'projects';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::PROJECTS_IMAGES_TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('project_id')->references('id')->on(self::PROJECTS_TABLE);
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
        Schema::dropIfExists(self::PROJECTS_IMAGES_TABLE);
    }
}
