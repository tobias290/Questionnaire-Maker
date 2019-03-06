<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuestionOpen extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("question_open", function (Blueprint $table) {
            $table->increments("id");

            $table->string("name");
            $table->integer("position");
            $table->boolean("is_required");
            $table->boolean("is_long");
            $table->integer("questionnaire_id");

            $table->foreign("questionnaire_id")
                ->references("id")
                ->on("questionnaire");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop("question_open");
    }
}
