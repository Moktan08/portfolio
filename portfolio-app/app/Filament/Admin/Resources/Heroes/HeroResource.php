<?php

namespace App\Filament\Admin\Resources\Heroes;

use App\Filament\Admin\Resources\Heroes\Pages;
use App\Filament\Admin\Resources\Heroes\Pages\CreateHero;
use App\Filament\Admin\Resources\Heroes\Pages\EditHero;
use App\Filament\Admin\Resources\Heroes\Pages\ListHeroes;
use App\Filament\Admin\Resources\Heroes\Schemas\HeroForm;
use App\Filament\Admin\Resources\Heroes\Tables\HeroesTable;
use App\Models\Hero;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class HeroResource extends Resource
{
    protected static ?string $model = Hero::class;

    protected static ?string $navigationLabel = 'Job Title';

    protected static ?string $pluralLabel = 'Job Title';  

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return HeroForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('tagline')->limit(50),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHeroes::route('/'),
            'create' => CreateHero::route('/create'),
            'edit' => EditHero::route('/{record}/edit'),
        ];
    }
}
