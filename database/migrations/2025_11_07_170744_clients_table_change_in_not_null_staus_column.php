<?php

use App\Enums\Client\ClientStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('clients')
            ->whereNull('status')
            ->update(['status' => ClientStatusEnum::Pending->value]);
        Schema::table('clients', function (Blueprint $table) {
            $table
                ->string('status', 150)
                ->default(ClientStatusEnum::Pending->value)
                ->nullable(false)
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table
                ->string('status', 150)
                ->nullable()
                ->default(null)
                ->change();
        });
    }
};
