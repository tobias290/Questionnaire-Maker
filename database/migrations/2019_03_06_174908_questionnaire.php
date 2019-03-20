<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Questionnaire extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("questionnaire", function (Blueprint $table) {
            $table->increments("id");

            $table->string("title");
            $table->string("description")->nullable();

            $table->boolean("is_public")->default(false);
            $table->boolean("is_complete")->default(false);
            $table->boolean("is_reported")->default(false);
            $table->boolean("is_locked")->default(false);

            $table->integer("responses")->default(0);

            $table->date("expiry_date")->nullable();
            $table->timestamps();

            $table->integer("questionnaire_category_id")->unsigned();
            $table->bigInteger("user_id")->unsigned();

            $table->foreign("questionnaire_category_id")
                ->references("id")
                ->on("questionnaire_category")
                ->onDelete("cascade");

            $table->foreign("user_id")
                ->references("id")
                ->on("user")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop("questionnaire");

    }
}
