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
        Schema::create('m_products', function (Blueprint $table) {
            $table->id()->comment('商品ID');
            $table->unsignedBigInteger('scrape_site_id')->comment('スクレイプID');
            $table->string('name')->comment('商品名');
            $table->unsignedBigInteger('category_id')->comment('カテゴリーID');
            $table->integer('price')->comment('価格');
            $table->text('description')->nullable()->comment('商品説明');
            $table->integer('sort_order')->nullable()->comment('並び順');
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
        Schema::dropIfExists('m_products');
    }
};
