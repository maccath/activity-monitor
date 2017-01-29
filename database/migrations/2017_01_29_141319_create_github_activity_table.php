<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGithubActivityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('github_activities', function (Blueprint $table) {
            $table->string('id');
            $table->text('json');
            $table->text('type');
            $table->text('repo_id')->nullable();
            $table->text('repo_name')->nullable();
            $table->string('user_id')->nullable();
            $table->string('user_name')->nullable();
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
        Schema::dropIfExists('github_activities');
    }
}
