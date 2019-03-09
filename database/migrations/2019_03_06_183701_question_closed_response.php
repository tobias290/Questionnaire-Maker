<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuestionClosedResponse extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("question_closed_response", function (Blueprint $table) {
            $table->increments("id");
            $table->integer("question_closed_option_id")->unsigned();

            $table->foreign("question_closed_option_id")
                ->references("id")
                ->on("question_closed_option");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop("question_closed_response");
    }
}
