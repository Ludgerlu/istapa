<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MonthlyViewsStat;
use App\Models\Blog;
use App\Models\Program;
use Illuminate\Http\JsonResponse;

class MonthlyViewsStatsController extends Controller
{
    /**
     * Retourne l'historique mensuel de vues d'un blog_post ou d'un program,
     * trié chronologiquement, pour alimenter le modal de statistiques.
     */
    public function data(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'item_type' => ['required', 'in:blog_post,program'],
            'item_id'   => ['required', 'integer'],
        ]);

        $rows = MonthlyViewsStat::query()
            ->where('item_type', $validated['item_type'])
            ->where('item_id', $validated['item_id'])
            ->orderBy('year')
            ->orderBy('month')
            ->get(['year', 'month', 'month_views', 'cumulative_views']);

        $label = $validated['item_type'] === 'blog_post'
            ? optional(Blog::find($validated['item_id']))->title_fr
            : optional(Program::find($validated['item_id']))->title_fr;

        return response()->json([
            'label' => $label,
            'rows'  => $rows,
        ]);
    }
}