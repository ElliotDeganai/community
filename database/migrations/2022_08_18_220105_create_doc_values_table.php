<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_values', function (Blueprint $table) {
            $table->id();
            $table->string('value_text')->nullable();
            $table->longText('value_html')->nullable();
            $table->float('value_number', 12, 2)->nullable();
            $table->float('value_price', 12, 2)->nullable();
            $table->date('value_date')->nullable();
            $table->timestamp('value_date_time')->nullable();
            $table->string('value_list')->nullable();
            $table->string('value_link')->nullable();
            $table->boolean('value_audio')->nullable();
            $table->boolean('value_gallery')->nullable();
            $table->boolean('value_image')->nullable();
            $table->boolean('value_carousel')->nullable();
            $table->integer('documentation_id');
            $table->integer('post_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('doc_values');
    }
}
