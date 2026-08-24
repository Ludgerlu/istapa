<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class RecordMonthlyViewsStats extends Command
{
   /**
     * Nom et signature de la commande.
     * Lancement manuel : php artisan stats:record-monthly-views
     */
    protected $signature = 'stats:record-monthly-views';

    protected $description = "Enregistre l'instantané mensuel des vues (blog_posts et programs) dans monthly_views_stats";

    public function handle(): int
    {
        $year  = now()->year;
        $month = now()->month;

        DB::transaction(function () use ($year, $month) {

            // ── Articles de blog ────────────────────────────────────────
            DB::statement("
                INSERT INTO monthly_views_stats
                    (item_type, item_id, year, month, cumulative_views, month_views)
                SELECT
                    'blog_post',
                    b.id,
                    ?,
                    ?,
                    b.view_count,
                    GREATEST(b.view_count - COALESCE((
                        SELECT m.cumulative_views
                        FROM monthly_views_stats m
                        WHERE m.item_type = 'blog_post'
                          AND m.item_id   = b.id
                        ORDER BY m.year DESC, m.month DESC
                        LIMIT 1
                    ), 0), 0)
                FROM blog_posts b
                ON DUPLICATE KEY UPDATE
                    cumulative_views = VALUES(cumulative_views),
                    month_views       = VALUES(month_views),
                    recorded_at       = CURRENT_TIMESTAMP
            ", [$year, $month]);

            // ── Programmes ───────────────────────────────────────────────
            DB::statement("
                INSERT INTO monthly_views_stats
                    (item_type, item_id, year, month, cumulative_views, month_views)
                SELECT
                    'program',
                    p.id,
                    ?,
                    ?,
                    p.view_count,
                    GREATEST(p.view_count - COALESCE((
                        SELECT m.cumulative_views
                        FROM monthly_views_stats m
                        WHERE m.item_type = 'program'
                          AND m.item_id   = p.id
                        ORDER BY m.year DESC, m.month DESC
                        LIMIT 1
                    ), 0), 0)
                FROM programs p
                ON DUPLICATE KEY UPDATE
                    cumulative_views = VALUES(cumulative_views),
                    month_views       = VALUES(month_views),
                    recorded_at       = CURRENT_TIMESTAMP
            ", [$year, $month]);
        });

        $this->info("Statistiques de vues enregistrées pour {$month}/{$year}.");

        return self::SUCCESS;
    }
}
