<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoemailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autoemails', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('created_by');
            $table->integer('updated_by');

            $table->longText('comment')->nullable();

            $table->boolean('active')->default(true);

            $table->string('email1')->nullable();
            $table->string('email2')->nullable();
            $table->string('saa')->nullable();
            $table->string('sbb')->nullable();
            $table->string('scc')->nullable();
            $table->string('sdd')->nullable();
            $table->string('see')->nullable();
            $table->string('sff')->nullable();

            $table->boolean('boolaa')->default(false);
            $table->boolean('boolbb')->default(false);
            $table->boolean('boolcc')->default(false);
            $table->boolean('booldd')->default(false);

            $table->integer('iaa')->nullable();
            $table->integer('ibb')->nullable();
            $table->integer('icc')->nullable();
            $table->integer('idd')->nullable();
            $table->integer('iee')->nullable();
            $table->integer('iff')->nullable();

            $table->longText('laa')->nullable();
            $table->longText('lbb')->nullable();
            $table->longText('lcc')->nullable();
            $table->longText('ldd')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('autoemails');
    }
}
