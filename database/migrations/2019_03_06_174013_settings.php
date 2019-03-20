<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Settings extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("settings", function (Blueprint $table) {
            $table->bigInteger("user_id")->unsigned();
            $table->boolean("enable_in_app_notifications")->default(true);
            $table->boolean("enable_email_notifications")->default(true);
            $table->enum("questionnaire_expiration_notification", ["none", "day", "week", "month"])->default("day");

            $table->foreign("user_id")->references("id")->on("user")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop("settings");
    }
}
