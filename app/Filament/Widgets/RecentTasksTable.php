<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTasksTable extends BaseWidget
{
    protected static ?string $heading = 'Recent Tasks';

    public function table(Table $table): Table
    {
        return $table
            ->query(Task::query()->latest('created_at')->limit(10)->with(['project','assignedUser']))
            ->columns([
                TextColumn::make('name')->label('Task')->searchable(),
                TextColumn::make('project.name')->label('Project')->searchable(),
                TextColumn::make('assignedUser.name')->label('Assignee')->toggleable(),
                BadgeColumn::make('status')->colors([
                    'primary' => 'pending',
                    'warning' => 'on_hold',
                    'info' => 'in_progress',
                    'success' => 'completed',
                    'danger' => 'cancelled',
                ]),
                TextColumn::make('due_date')->date()->label('Due'),
                TextColumn::make('created_at')->since()->label('Created'),
            ]);
    }
}


