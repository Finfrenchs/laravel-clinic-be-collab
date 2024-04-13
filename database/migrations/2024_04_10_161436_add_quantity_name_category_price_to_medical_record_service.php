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
        Schema::table('medical_record_service', function (Blueprint $table) {
            $table->integer('quantity')->default(0);
            // $table->string("name");
            // $table->enum("category", ['obat-obatan', 'alat kesehatan', 'konsultasi doctor']);
            // $table->integer("price");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_record_service', function (Blueprint $table) {
            $table->dropColumn('quantity');
            // $table->dropColumn("name");
            // $table->dropColumn("category", ['obat-obatan', 'alat kesehatan', 'konsultasi doctor']);
            // $table->dropColumn("price");
        });
    }
};
