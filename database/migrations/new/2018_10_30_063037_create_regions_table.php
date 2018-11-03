<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')
                ->comment('名称');

            $table->string('code')
                ->comment('代码');

            $table->unsignedInteger('pid')
                ->default(0)
                ->comment('上级id');

            $table->unsignedInteger('root_id')
                ->default(0)
                ->comment('根节点id');

            $table->unsignedTinyInteger('type')
                ->comment('类型。1=Country；2=State；3=City; 4=Region');

            $table->unique(['name', 'pid', 'type']);
            $table->index('pid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions');
    }
}
