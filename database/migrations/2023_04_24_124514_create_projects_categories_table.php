<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProjectsCategoriesTable extends Migration
{
    public const PROJECTS_CATEGORIES_TABLE = 'projects_categories';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::PROJECTS_CATEGORIES_TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table(self::PROJECTS_CATEGORIES_TABLE)->insert(
            array(
                [
                    'name' => 'Identities',
                ],
                [
                    'name' => 'Amazon listing'
                ],
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(self::PROJECTS_CATEGORIES_TABLE);
    }
}
