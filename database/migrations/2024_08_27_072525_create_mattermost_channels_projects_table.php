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
        Schema::create('mattermost_channels_projects', static function (Blueprint $table): void {
            $table->id();
            $table->string('channel_id');
            $table->string('project');
            $table->boolean('workflow_enabled')->default(true);
            $table->timestamps();

            $table->foreign('channel_id')->references('id')->on('mattermost_channels')->onDelete('cascade');
            $table->unique(['channel_id', 'project']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mattermost_channels_projects');
    }
};
