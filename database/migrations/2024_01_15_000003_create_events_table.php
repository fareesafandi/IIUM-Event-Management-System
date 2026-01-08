<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('venue');
            $table->date('date');
            $table->time('time');
            $table->string('poster_image')->nullable();
            $table->enum('status', ['open', 'closed', 'full', 'cancelled', 'upcoming'])->default('open');
            $table->integer('max_participants')->nullable();
            $table->foreignId('manager_id')->constrained('users')->onDelete('cascade');
            $table->string('organizer_name')->nullable();
            $table->string('organizer_contact')->nullable();
            $table->string('organizer_email')->nullable();
            $table->timestamps();
            
            // Indexes for better query performance
            $table->index('date');
            $table->index('status');
            $table->index('manager_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
