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
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('guest_gender', 10)->nullable()->after('user_id');
            $table->string('guest_first_name', 100)->nullable()->after('guest_gender');
            $table->string('guest_last_name', 100)->nullable()->after('guest_first_name');
            $table->string('guest_email', 100)->nullable()->after('guest_last_name');
            $table->string('guest_phone_number', 20)->nullable()->after('guest_email');

            $table->boolean('agreed_dietary_policy')->default(false)->after('notes');
            $table->boolean('receive_promotions')->default(false)->after('agreed_dietary_policy');
            $table->boolean('personalized_recommendations')->default(false)->after('receive_promotions');
            $table->boolean('agreed_terms')->default(false)->after('personalized_recommendations');
            $table->boolean('agreed_cancellation_policy')->default(false)->after('agreed_terms');

            $table->string('payment_method', 50)->nullable()->after('agreed_cancellation_policy');
            $table->string('voucher_code', 50)->nullable()->after('payment_method');
            $table->decimal('hold_amount', 10, 2)->nullable()->after('voucher_code');
            $table->string('transaction_id', 255)->nullable()->after('hold_amount');
            $table->string('payment_status', 50)->default('Pending')->after('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn([
                'guest_gender',
                'guest_first_name',
                'guest_last_name',
                'guest_email',
                'guest_phone_number',
                'agreed_dietary_policy',
                'receive_promotions',
                'personalized_recommendations',
                'agreed_terms',
                'agreed_cancellation_policy',
                'payment_method',
                'voucher_code',
                'hold_amount',
                'transaction_id',
                'payment_status',
            ]);
        });
    }
};
