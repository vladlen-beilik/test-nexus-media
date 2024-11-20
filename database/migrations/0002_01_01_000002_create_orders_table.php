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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('foreign_id')->index()->unique();
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->decimal('total_price', 20);
            $table->string('financial_status');
            $table->string('fulfillment_status')->nullable();
//
            $table->timestamp('foreign_created_at');
            $table->timestamp('foreign_updated_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
