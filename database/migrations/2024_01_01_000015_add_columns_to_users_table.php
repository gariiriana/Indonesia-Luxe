<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'delivery_address')) {
                $table->text('delivery_address')->nullable()->after('avatar');
            }
            if (!Schema::hasColumn('users', 'delivery_city')) {
                $table->string('delivery_city')->nullable();
            }
            if (!Schema::hasColumn('users', 'delivery_province')) {
                $table->string('delivery_province')->nullable();
            }
            if (!Schema::hasColumn('users', 'delivery_postal')) {
                $table->string('delivery_postal')->nullable();
            }
            if (!Schema::hasColumn('users', 'notif_email')) {
                $table->boolean('notif_email')->default(true);
            }
            if (!Schema::hasColumn('users', 'notif_promo')) {
                $table->boolean('notif_promo')->default(true);
            }
            if (!Schema::hasColumn('users', 'notif_sms')) {
                $table->boolean('notif_sms')->default(false);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['delivery_address', 'delivery_city', 'delivery_province', 'delivery_postal', 'notif_email', 'notif_promo', 'notif_sms']);
        });
    }
};
