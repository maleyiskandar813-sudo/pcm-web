<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->dateTime('starts_at');
            $table->dateTime('ends_at')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('aum', function (Blueprint $table) {
            $table->id();
            $table->string('type', 30)->index();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->text('description')->nullable();
            $table->string('maps_url')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aum');
        Schema::dropIfExists('announcements');
        Schema::dropIfExists('agenda');
    }
};
