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
        Schema::create('mattermost_channels', static function (Blueprint $table): void {
            $table->string('id')->primary();
            $table->string('team_id');
            $table->string('name');
            $table->string('display_name');
            $table->boolean('is_private')->default(false);
            $table->timestamps();

            $table->unique(['id', 'team_id']);
            $table->foreign('team_id')->references('id')->on('mattermost_teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mattermost_channels');
    }
};
