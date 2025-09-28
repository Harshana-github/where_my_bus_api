<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('routes', function (Blueprint $table) {
            // 1) Add nullable FK columns first
            $table->unsignedBigInteger('start_town_id')->nullable()->after('route_name');
            $table->unsignedBigInteger('end_town_id')->nullable()->after('start_town_id');

            // 2) Add foreign keys (defer to after we backfill if you want to avoid constraint issues)
            // We'll add constraints after backfill, so comment for now if your DB enforces immediately:
            // $table->foreign('start_town_id')->references('id')->on('towns')->cascadeOnUpdate()->nullOnDelete();
            // $table->foreign('end_town_id')->references('id')->on('towns')->cascadeOnUpdate()->nullOnDelete();
        });

        // 3) Backfill: map existing start_location/end_location strings to towns
        //    - Try to find a town by exact name (case-insensitive)
        //    - If not found, create it (optional) and link it
        $routes = DB::table('routes')->select('id', 'start_location', 'end_location')->get();

        foreach ($routes as $r) {
            $startTownId = null;
            $endTownId   = null;

            if ($r->start_location !== null && $r->start_location !== '') {
                $startTown = DB::table('towns')
                    ->whereRaw('LOWER(name) = ?', [mb_strtolower($r->start_location)])
                    ->first();

                if (!$startTown) {
                    // Create town if not exists (optional; remove if you prefer to fail instead)
                    $startTownId = DB::table('towns')->insertGetId([
                        'name'       => $r->start_location,
                        'is_active'  => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $startTownId = $startTown->id;
                }
            }

            if ($r->end_location !== null && $r->end_location !== '') {
                $endTown = DB::table('towns')
                    ->whereRaw('LOWER(name) = ?', [mb_strtolower($r->end_location)])
                    ->first();

                if (!$endTown) {
                    $endTownId = DB::table('towns')->insertGetId([
                        'name'       => $r->end_location,
                        'is_active'  => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } else {
                    $endTownId = $endTown->id;
                }
            }

            DB::table('routes')
                ->where('id', $r->id)
                ->update([
                    'start_town_id' => $startTownId,
                    'end_town_id'   => $endTownId,
                    'updated_at'    => now(),
                ]);
        }

        // 4) Now that data is filled, add the actual FK constraints
        Schema::table('routes', function (Blueprint $table) {
            $table->foreign('start_town_id')
                ->references('id')->on('towns')
                ->cascadeOnUpdate()->nullOnDelete();

            $table->foreign('end_town_id')
                ->references('id')->on('towns')
                ->cascadeOnUpdate()->nullOnDelete();
        });

        // 5) Finally, drop the old string columns
        Schema::table('routes', function (Blueprint $table) {
            if (Schema::hasColumn('routes', 'start_location')) {
                $table->dropColumn('start_location');
            }
            if (Schema::hasColumn('routes', 'end_location')) {
                $table->dropColumn('end_location');
            }
        });
    }

    public function down(): void
    {
        // Reverse: add back old columns and try to restore values from towns
        Schema::table('routes', function (Blueprint $table) {
            $table->string('start_location')->nullable()->after('route_name');
            $table->string('end_location')->nullable()->after('start_location');
        });

        // Attempt to restore string names from towns
        $routes = DB::table('routes')->select('id', 'start_town_id', 'end_town_id')->get();
        foreach ($routes as $r) {
            $startName = null;
            $endName   = null;

            if ($r->start_town_id) {
                $startTown = DB::table('towns')->where('id', $r->start_town_id)->first();
                $startName = $startTown?->name;
            }
            if ($r->end_town_id) {
                $endTown = DB::table('towns')->where('id', $r->end_town_id)->first();
                $endName = $endTown?->name;
            }

            DB::table('routes')->where('id', $r->id)->update([
                'start_location' => $startName,
                'end_location'   => $endName,
                'updated_at'     => now(),
            ]);
        }

        // Drop FKs + new columns
        Schema::table('routes', function (Blueprint $table) {
            if (Schema::hasColumn('routes', 'start_town_id')) {
                $table->dropForeign(['start_town_id']);
                $table->dropColumn('start_town_id');
            }
            if (Schema::hasColumn('routes', 'end_town_id')) {
                $table->dropForeign(['end_town_id']);
                $table->dropColumn('end_town_id');
            }
        });
    }
};
