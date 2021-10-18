<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');

            $table->timestamps();
        });

        Schema::table('empleados', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('id');

            $table->foreign('category_id')->references('id')->on('categories')
            ->onDelete('set null')
            ->onUpdate('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empleados', function (Blueprint $table) {
            $table->dropForeign('empleados_category_id_foreign');

            $table->dropColumn('category_id'); 
        });
        Schema::dropIfExists('categories');
    }
}
