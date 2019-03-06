<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuestionScaled extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("question_scaled", function (Blueprint $table) {
            $table->increments("id");

            $table->string("name");

            $table->integer("position");

            $table->float("min");
            $table->float("max");
            $table->float("interval");

            $table->enum("type", ["scaled", "star", "slider"]);

            $table->boolean("is_required");

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
        Schema::drop("question_scaled");
    }
}
