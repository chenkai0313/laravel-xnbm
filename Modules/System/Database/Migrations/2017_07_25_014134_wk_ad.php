<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class WkAd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_type', function (Blueprint $table){
            $table->tinyIncrements('type_id');
            $table->string('type_name',50)->comment('广告类型名称');
            $table->string('img_size',100)->comment('广告图片大小,例如长,宽');
            $table->timestamps();
            $table->engine('MyISAM');
        });
        Schema::create('ad', function (Blueprint $table) {
            $table->tinyIncrements('ad_id')->index('ad_id');
            $table->tinyInteger('type_id')->index('type_id')->comment('ad_type的主键');
            $table->string('ad_img')->nullable()->default('')->comment('广告图片');
            $table->tinyInteger('is_show')->default(0)->comment('1为不显示,0为显示');
            $table->softDeletes();
            $table->timestamps();
            $table->engine('MyISAM');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_type');
        Schema::dropIfExists('ad');
    }
}
