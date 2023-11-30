<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('title')->index();
            $table->text('description')->nullable();
            $table->string('repeat_type')->nullable()->default('once')->comment('once, daily, weekly, monthly, yearly');
            $table->dateTime('notification_date_time')->nullable();
            $table->dateTime('deadline_date_time')->nullable();
            $table->boolean('is_done')->nullable()->default(false);
            $table->boolean('is_important')->nullable()->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reminders');
    }
};
