<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            $table->string('invoice_number', 100)->unique();
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('due_amount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('completed');
            $table->timestamp('sale_date')->useCurrent();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index('invoice_number');
            $table->index('sale_date');

            Schema::table('purchases', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('set null');
            });

            Schema::table('sales', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('set null');
            });
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};