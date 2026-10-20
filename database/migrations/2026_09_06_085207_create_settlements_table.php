<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')->constrained('trips')->cascadeOnDelete();
            $table->foreignId('from_trip_member_id')->constrained('trip_members')->cascadeOnDelete();
            $table->foreignId('to_trip_member_id')->constrained('trip_members')->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->string('note')->nullable();
            $table->date('settled_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settlements');
    }
};