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
        Schema::create('mattermost_commands', static function (Blueprint $table): void {
            $table->id();
            $table->string('external_id')->unique()->nullable();
            $table->string('token')->nullable();
            $table->timestamp('create_at')->nullable();
            $table->timestamp('update_at')->nullable();
            $table->timestamp('delete_at')->nullable();
            $table->string('creator_id')->nullable();
            $table->string('team_id');
            $table->string('trigger');
            $table->string('method');
            $table->string('username')->nullable();
            $table->string('icon_url')->nullable();
            $table->boolean('auto_complete')->default(false);
            $table->string('auto_complete_desc')->nullable();
            $table->string('auto_complete_hint')->nullable();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->string('url');
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('mattermost_teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mattermost_commands');
    }
};
