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

            $table->float("min")->default(0);
            $table->float("max")->default(5);
            $table->float("interval")->default(1);

            $table->enum("type", ["star", "slider"]);

            $table->boolean("is_required")->default(false);

            $table->integer("questionnaire_id")->unsigned();

            $table->foreign("questionnaire_id")
                ->references("id")
                ->on("questionnaire")
                ->onDelete("cascade");
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
