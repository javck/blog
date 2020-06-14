<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('name',150);
            $table->date('published_time');
            $table->timestamp('sell_at')->nullable();
            $table->bigInteger('album_id')->index()->unsigned();
            $table->bigInteger('cgy_id')->index()->unsigned();
            $table->foreign('cgy_id')->references('id')->on('cgies')->onDelete('cascade');
            $table->string('url',255);
            $table->string('cover', 255)->nullable();
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
        Schema::table('songs', function (Blueprint $table) {
            $table->dropForeign(['cgy_id']);
        });
        Schema::dropIfExists('songs');
    }
}
