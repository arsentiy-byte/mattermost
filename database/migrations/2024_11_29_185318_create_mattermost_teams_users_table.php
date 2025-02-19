<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mattermost_users_teams', static function (Blueprint $table): void {
            $table->id();
            $table->string('user_id');
            $table->string('team_id');
            $table->timestamps();

            $table->unique(['team_id', 'user_id']);

            $table->foreign('user_id')->references('id')->on('mattermost_users')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('mattermost_teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mattermost_teams_users');
    }
};
