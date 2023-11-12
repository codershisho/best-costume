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
        Schema::create('m_customers', function (Blueprint $table) {
            $table->id()->comment('顧客ID');
            $table->string('name')->comment('顧客名');
            $table->string('phone')->comment('電話番号');
            $table->date('visit_date')->default(now())->comment('来店日');
            $table->unsignedBigInteger('status_id')->default(1)->comment('ステータスID');
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
        Schema::dropIfExists('m_customers');
    }
};
