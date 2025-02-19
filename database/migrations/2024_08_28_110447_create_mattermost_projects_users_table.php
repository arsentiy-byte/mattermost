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
        Schema::create('mattermost_projects_users', static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('channel_project_id');
            $table->string('user_id');
            $table->timestamps();

            $table->unique(['channel_project_id', 'user_id']);
            $table->foreign('channel_project_id')->references('id')->on('mattermost_channels_projects')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('mattermost_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mattermost_projects_users');
    }
};
