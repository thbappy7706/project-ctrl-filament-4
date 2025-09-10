<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProjectStatsOverview extends BaseWidget
{



    protected function getStats(): array
    {
        $projectsTotal = Project::query()->count();
        $projectsInProgress = Project::query()->where('status', 'in_progress')->count();
        $projectsCompleted = Project::query()->where('status', 'completed')->count();

        $tasksTotal = Task::query()->count();
        $tasksOverdue = Task::query()
            ->whereNotNull('due_date')
            ->where('due_date', '<', now()->toDateString())
            ->whereNot('status', 'completed')
            ->count();

        return [
            Stat::make('Projects', (string) $projectsTotal)
                ->description("{$projectsInProgress} in progress, {$projectsCompleted} completed")
                ->color('primary'),
            Stat::make('Tasks', (string) $tasksTotal)
                ->description("{$tasksOverdue} overdue")
                ->color($tasksOverdue > 0 ? 'danger' : 'success'),
        ];
    }
}


