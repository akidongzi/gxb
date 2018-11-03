<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateArticleRelLabelTableAddUniqueIndexToLabelAndArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('article_rel_labels', function (Blueprint $table) {
            $table->unique(['article_id', 'label_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_rel_labels', function (Blueprint $table) {
            $table->dropIndex(['article_id', 'label_id']);
        });
    }
}
