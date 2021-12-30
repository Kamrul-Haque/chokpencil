<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('discussion_panel_id');
            $table->unsignedBigInteger('user_id');
            $table->string('subject');
            $table->text('body');
            $table->unsignedBigInteger('content_id')->nullable();
            $table->unsignedBigInteger('assessment_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('discussion_panel_id')->on('discussion_panels')->references('id')->onDelete('cascade');
            $table->foreign('content_id')->on('contents')->references('id')->onDelete('cascade');
            $table->foreign('assessment_id')->on('assessments')->references('id')->onDelete('cascade');
            $table->foreign('user_id')->on('users')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
}
