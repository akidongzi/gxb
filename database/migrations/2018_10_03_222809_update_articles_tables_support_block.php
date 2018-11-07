<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateArticlesTablesSupportBlock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
           
            $table->string('covers', 255)
                ->default(0)
                ->after('banner')
                ->comment('封面图');

            $table->integer('pv')
                ->default(0)
                ->after('content')
                ->comment('发布时间');

            $table->dateTime('published_at')
                ->nullable()
                ->after('pv')
                ->comment('发布时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('covers');
            $table->dropColumn('pv');
            $table->dropColumn('published_at');
        });
    }
}
