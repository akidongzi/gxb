<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePositionsTablesSupportBlockAddDefaultValues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('positions', function (Blueprint $table) {
           
            $table->string('code', 255)
                ->after('id')
                ->comment('编码');

            $table->string('sort_type')
                ->default(0)
                ->comment('排序方式: 0 时间倒序;1 热度倒序;')
                ->change();
            $table->string('content_ids')
                ->default('')
                ->comment('内容id')
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
        Schema::table('positions', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
}
