<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Visitors table indexes
        $this->createIndexIfNotExists('visitors', 'visit_date', 'idx_visitors_visit_date');
        $this->createIndexIfNotExists('visitors', 'purpose', 'idx_visitors_purpose');
        $this->createIndexIfNotExists('visitors', ['visit_date', 'purpose'], 'idx_visitors_visit_date_purpose');
        $this->createIndexIfNotExists('visitors', 'created_at', 'idx_visitors_created_at');

        // Tournaments table indexes
        $this->createIndexIfNotExists('tournaments', 'date', 'idx_tournaments_date');
        $this->createIndexIfNotExists('tournaments', 'status', 'idx_tournaments_status');
        $this->createIndexIfNotExists('tournaments', 'game', 'idx_tournaments_game');
        $this->createIndexIfNotExists('tournaments', ['date', 'status'], 'idx_tournaments_date_status');
        $this->createIndexIfNotExists('tournaments', 'created_at', 'idx_tournaments_created_at');

        // News table indexes
        $this->createIndexIfNotExists('news', 'category', 'idx_news_category');
        $this->createIndexIfNotExists('news', 'created_at', 'idx_news_created_at');
        $this->createIndexIfNotExists('news', ['category', 'created_at'], 'idx_news_category_created');

        // Events table indexes
        $this->createIndexIfNotExists('events', 'start_date', 'idx_events_start_date');
        $this->createIndexIfNotExists('events', 'status', 'idx_events_status');
        $this->createIndexIfNotExists('events', 'category', 'idx_events_category');
        $this->createIndexIfNotExists('events', ['start_date', 'status'], 'idx_events_start_date_status');
        $this->createIndexIfNotExists('events', 'is_public', 'idx_events_is_public');
        $this->createIndexIfNotExists('events', 'created_at', 'idx_events_created_at');

        // Expressions table indexes (if exists)
        if (Schema::hasTable('expressions')) {
            $this->createIndexIfNotExists('expressions', 'created_at', 'idx_expressions_created_at');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->dropIndexIfExists('visitors', 'idx_visitors_visit_date');
        $this->dropIndexIfExists('visitors', 'idx_visitors_purpose');
        $this->dropIndexIfExists('visitors', 'idx_visitors_visit_date_purpose');
        $this->dropIndexIfExists('visitors', 'idx_visitors_created_at');

        $this->dropIndexIfExists('tournaments', 'idx_tournaments_date');
        $this->dropIndexIfExists('tournaments', 'idx_tournaments_status');
        $this->dropIndexIfExists('tournaments', 'idx_tournaments_game');
        $this->dropIndexIfExists('tournaments', 'idx_tournaments_date_status');
        $this->dropIndexIfExists('tournaments', 'idx_tournaments_created_at');

        $this->dropIndexIfExists('news', 'idx_news_category');
        $this->dropIndexIfExists('news', 'idx_news_created_at');
        $this->dropIndexIfExists('news', 'idx_news_category_created');

        $this->dropIndexIfExists('events', 'idx_events_start_date');
        $this->dropIndexIfExists('events', 'idx_events_status');
        $this->dropIndexIfExists('events', 'idx_events_category');
        $this->dropIndexIfExists('events', 'idx_events_start_date_status');
        $this->dropIndexIfExists('events', 'idx_events_is_public');
        $this->dropIndexIfExists('events', 'idx_events_created_at');

        if (Schema::hasTable('expressions')) {
            $this->dropIndexIfExists('expressions', 'idx_expressions_created_at');
        }
    }

    /**
     * Create index if it doesn't exist.
     */
    private function createIndexIfNotExists(string $table, string|array $columns, string $indexName): void
    {
        if (DB::getDriverName() === 'mysql') {
            if (! $this->indexExists($table, $indexName)) {
                $columns = is_array($columns) ? implode(',', $columns) : $columns;
                DB::statement("CREATE INDEX {$indexName} ON {$table} ({$columns})");
            }
        } else {
            try {
                $columns = is_array($columns) ? $columns : [$columns];
                Schema::table($table, function (\Illuminate\Database\Schema\Blueprint $tableBlueprint) use ($columns, $indexName) {
                    $tableBlueprint->index($columns, $indexName);
                });
            } catch (\Throwable $e) {
                // Index might already exist
            }
        }
    }

    /**
     * Drop index if it exists.
     */
    private function dropIndexIfExists(string $table, string $indexName): void
    {
        if (DB::getDriverName() === 'mysql') {
            if ($this->indexExists($table, $indexName)) {
                DB::statement("DROP INDEX {$indexName} ON {$table}");
            }
        } else {
            try {
                Schema::table($table, function (\Illuminate\Database\Schema\Blueprint $tableBlueprint) use ($indexName) {
                    $tableBlueprint->dropIndex($indexName);
                });
            } catch (\Throwable $e) {
                // Index might not exist
            }
        }
    }

    /**
     * Check if an index exists.
     */
    private function indexExists(string $table, string $indexName): bool
    {
        $result = DB::select("SHOW INDEX FROM {$table} WHERE Key_name = ?", [$indexName]);

        return ! empty($result);
    }
};
