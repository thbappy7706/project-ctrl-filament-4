<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                TextInput::make('guard_name')->label('Guard')->default('web')->required(),
                Select::make('permissions')
                    ->label('Permissions')
                    ->relationship(name: 'permissions', titleAttribute: 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
            ]);
    }
}


