<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFabricDischargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fabricdischarges', function (Blueprint $table) {
            $table->increments('id');

            $table->string('department');                                               //部门
            $table->string('contactor');                                          //联系人
            $table->string('contactor_tel');                                      //联系人电话
            $table->string('style');                                              //款号
            $table->string('version');                                            //版本
            $table->string('applydate');                                          //申请日期
            $table->string('status');                                             //紧急状态
            $table->string('style_des')->nullable();                                          //款式描述
            $table->string('fabric_specification')->nullable();                               //面料成分规格
            $table->integer('weight')->nullable();                                            //克重
            $table->integer('width')->nullable();                                            //门幅
            $table->string('lattice_cycle')->nullable();                                       //格子循环
            $table->string('requirement')->nullable();                                         //对格对条要求
            $table->integer('fabric_shrikage_grain')->default(2)->nullable();                              //面料缩率经向
            $table->integer('fabric_shrikage_zonal')->default(2)->nullable();                               //面料缩率纬向
            $table->integer('quantity')->nullable();                                           //数量
            $table->string('size_allotment')->nullable();                                      //尺码搭配
            $table->integer('XXS')->nullable();
            $table->integer('XS')->nullable();
            $table->integer('S')->nullable();
            $table->integer('M')->nullable();
            $table->integer('L')->nullable();
            $table->integer('XL')->nullable();
            $table->integer('XXL')->nullable();
            $table->integer('XXXL')->nullable();
            $table->string('note')->nullable();                                               //排料及用料记录
            $table->integer('flag1')->default(0);                                               //制版状态
            $table->integer('flag2')->default(0);                                               //排料状态
            $table->integer('num1')->default(0);                                               //制版数量
            $table->integer('num2')->default(0);                                               //排料数量
            $table->string('createname')->nullable();                                                       //创建人姓名

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fabricdischarges');
    }
}
