<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuestionOpenResponse extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("question_open_response", function (Blueprint $table) {
            $table->increments("id");
            $table->text("response");
            $table->integer("question_open_id");

            $table->foreign("question_open_id")
                ->references("id")
                ->on("question_open");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop("question_open_response");
    }
}
