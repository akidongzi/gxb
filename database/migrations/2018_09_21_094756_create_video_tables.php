<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('sort')
                ->comment('排序');

            $table->string('title')
                ->comment('标题');
            $table->string('source')
                ->nullable()
                ->comment('来源名称');

            $table->string('poster')
                ->nullable()
                ->comment('封面图');

            $table->string('file')
                ->comment('视频地址');

            $table->string('editor')
                ->comment('编辑');

            $table->unsignedBigInteger('size')
                ->comment('视频大小（Byte）');

            $table->softDeletes();
            $table->timestamps();
            $table->comment = '视频信息表';
        });

        Schema::create('video_rel_labels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('video_id')
                ->comment('视频id');

            $table->integer('label_id')
                ->comment('标签id');

            $table->unique(['video_id', 'label_id']);
            $table->timestamps();
            $table->comment = '视频标签关系表';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_rel_labels');
        Schema::dropIfExists('videos');
    }
}
