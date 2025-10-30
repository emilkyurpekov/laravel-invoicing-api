<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number', 50)->unique();
            $table->string('customer_name', 255);
            $table->string('customer_email', 255);
            $table->date('date');
            $table->date('due_date');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('vat', 10, 2);
            $table->decimal('total', 10, 2);
            $table->enum('status', ['unpaid', 'paid', 'draft']);
            $table->timestamps();
            $table->softDeletes();

            $table->index('number');
            $table->index('status');
            $table->index('customer_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
