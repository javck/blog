<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
 /**
  * Run the migrations.
  *
  * @return void
  */
 public function up()
 {
  Schema::table('users', function (Blueprint $table) {
   $table->string('provider', 30)->nullable();
   $table->string('provider_id', 100)->nullable();
   $table->string('password')->nullable()->change();
  });
 }

 public function down()
 {
  Schema::table('users', function (Blueprint $table) {
   $table->dropColumn('provider');
   $table->dropColumn('provider_id');
   $table->string('password')->change();
  });
 }
}
