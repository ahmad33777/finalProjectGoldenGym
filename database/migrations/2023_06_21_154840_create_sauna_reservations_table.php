<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sauna_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscriber_id')->constrained('subscribers')->onUpdate('cascade')->onDelete('cascade')->nullable(false);
            $table->date('booking_date'); //تاريخ الحجز
            $table->time('start_time'); // بداية  الحجز
            $table->time('end_time'); // نهاية  الحجز
            $table->integer('duration')->nullable()->default(1); // مدة الحجز
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sauna_reservations');
    }
};