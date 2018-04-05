<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTabsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tabs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id');
            $table->string('name');
            $table->string('link')->nullable();
            $table->string('comment')->nullable();
            $table->boolean('isActive')->default(false);
            $table->boolean('active')->default(true);
            $table->integer('isGShow')->default(false);
            $table->timestamps();
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tabs');
    }
}
