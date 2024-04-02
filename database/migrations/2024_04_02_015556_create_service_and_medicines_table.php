<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_and_medicines', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->enum("category", ['obat-obatan', 'alat kesehatan', 'konsultasi doctor']);
            $table->integer("price");
            $table->integer("quantity")->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_and_medicines');
    }
};
