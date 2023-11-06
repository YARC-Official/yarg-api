<?php

use App\Models\Band\Difficulty;
use App\Models\Band\Instrument;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Instrument::class)->nullable();
            $table->foreignIdFor(Difficulty::class)->nullable();

            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->foreignId('current_connected_account_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->string('country_code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}
