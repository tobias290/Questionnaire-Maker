<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuestionClosedOption extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("question_closed_option", function (Blueprint $table) {
            $table->increments("id");
            $table->string("option");
            $table->integer("question_closed_id")->unsigned();

            $table->foreign("question_closed_id")
                ->references("id")
                ->on("question_closed");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop("question_closed_option");
    }
}
