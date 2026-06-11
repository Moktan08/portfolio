<?php

namespace App\Filament\Admin\Resources\Education\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class EducationTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('degree')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('institution')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('location')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('duration')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
