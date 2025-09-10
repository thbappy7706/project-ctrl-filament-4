<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use Filament\Widgets\ChartWidget;

class ProjectsStatusChart extends ChartWidget
{


    protected function getData(): array
    {
        $statuses = ['pending','on_hold','in_progress','completed','cancelled'];
        $counts = [];
        foreach ($statuses as $status) {
            $counts[] = Project::query()->where('status', $status)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Projects',
                    'data' => $counts,
                    'backgroundColor' => [
                        '#60a5fa', '#f59e0b', '#10b981', '#22c55e', '#ef4444',
                    ],
                ],
            ],
            'labels' => array_map(fn ($s) => ucwords(str_replace('_', ' ', $s)), $statuses),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}


