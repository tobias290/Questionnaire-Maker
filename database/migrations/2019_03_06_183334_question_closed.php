<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuestionClosed extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("question_closed", function (Blueprint $table) {
            $table->increments("id");

            $table->string("name");
            $table->integer("position");
            $table->enum("type", ["check", "radio", "drop_down"]);
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
        Schema::drop("question_closed");
    }
}
