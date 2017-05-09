<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create the knowledges table.
 */
class CreateKnowledgesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('knowledges', function (Blueprint $table) {

            $table->string('uuid')->primary();
            $table->string('user_uuid')->nullable();
            $table->string('user_name')->nullable();
            $table->string('location_uuid');
            $table->string('image')->nullable();
            $table->string('image_medium')->nullable();
            $table->string('image_small')->nullable();
            $table->longText('content');
            $table->string('attachment')->nullable();
            $table->unsignedInteger('useful_count')->default(0);
            $table->unsignedInteger('useless_count')->default(0);
            $table->unsignedInteger('share_count')->default(0);
            $table->timestamps();

            $table->foreign('user_uuid')->references('uuid')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('location_uuid')->references('uuid')->on('locations')->onUpdate('cascade')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::drop('knowledges');

    }

}