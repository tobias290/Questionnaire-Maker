<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuestionScaledResponse extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("question_scaled_response", function (Blueprint $table) {
            $table->increments("id");
            $table->string("response");

            $table->integer("question_scaled_id")->unsigned();

            $table->foreign("question_scaled_id")
                ->references("id")
                ->on("question_scaled");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop("question_scaled_response");
    }
}
