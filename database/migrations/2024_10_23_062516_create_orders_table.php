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
            $table->string('transaction_code')->nullable();
            $table->string('status')->nullable();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->string('transaction_uuid')->nullable();
            $table->string('product_code')->nullable();
            $table->string('signed_field_names')->nullable();
            $table->text('signature')->nullable();
           
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
