<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvertLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convert_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tag_no')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->string('file_name')->nullable();
            $table->text('raw_file_path')->nullable();
            $table->text('gateway_response')->nullable();
            $table->integer('status')->default(0)->comment('0=pending/1=completed/2=failed');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convert_logs');
    }
}
