<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePositionsTablesSupportBlock extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->unsignedInteger('block_id')
                ->default(0)
                ->after('nav_show')
                ->comment('模块id');

            $table->string('content_ids')
                ->comment('内容id');

            $table->string('sort_type')
                ->after('nav_show')
                ->comment('排序方式: 0 时间倒序;1 热度倒序;');

            $table->unsignedInteger('num_show')
                ->default(0)
                ->after('nav_show')
                ->comment('显示数量: 0无限制;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->dropColumn('block_id');
            $table->dropColumn('content_ids');
            $table->dropColumn('sort_type');
            $table->dropColumn('num_show');
        });
    }
}
