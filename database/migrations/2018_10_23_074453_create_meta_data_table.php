<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_data', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('metable_type')
                ->comment('metable class');

            $table->string('metable_id')
                ->comment('metable id');

            $table->string('meta_key')
                ->comment('meta key');

            $table->longText('meta_value')
                ->comment('meta data');

            $table->timestamps();

            $table->unique(['metable_type', 'metable_id', 'meta_key']);
            $table->index('metable_type');
            $table->index('meta_key');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meta_data');
    }
}
