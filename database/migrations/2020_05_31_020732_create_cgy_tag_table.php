<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCgyTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cgy_tag', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cgy_id')->index();
            $table->foreign('cgy_id')->references('id')->on('cgies')->onDelete("cascade");
            $table->unsignedBigInteger('tag_id')->index();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete("cascade");
            $table->text('description')->nullable();
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
        Schema::table('cgy_tag', function (Blueprint $table) {
            $table->dropForeign(['cgy_id','tag_id']);
        });
        Schema::dropIfExists('cgy_tag');
    }
}
