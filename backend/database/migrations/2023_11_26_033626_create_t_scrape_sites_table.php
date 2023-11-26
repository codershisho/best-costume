<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_scrape_sites', function (Blueprint $table) {
            $table->id()->comment('スクレイプID');
            $table->unsignedBigInteger('site_id')->comment('サイトID');
            $table->text('url')->comment('URL');
            $table->string('title')->comment('タイトル');
            $table->text('description')->nullable()->comment('説明欄');
            $table->integer('price')->nullable()->comment('値段');
            $table->text('images')->nullable()->comment('画像URLのカンマ区切り');
            $table->text('note')->nullable()->comment('備考');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_scrape_sites');
    }
};
