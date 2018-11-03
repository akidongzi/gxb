<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterArticlesTableFixColsType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('meta_info');

            $table->text('covers')
                ->nullable()
                ->default(null)
                ->comment('封面图')
                ->change();
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
            $table->string('meta_info', 255)
                ->nullable()
                ->comment('元信息');

            $table->string('covers', 6000)
                ->default('')
                ->comment('封面图')
                ->change();
        });
    }
}
