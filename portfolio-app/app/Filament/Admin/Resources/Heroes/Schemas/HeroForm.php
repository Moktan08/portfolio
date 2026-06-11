<?php

namespace App\Filament\Admin\Resources\Heroes\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class HeroForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Hero Title / Role')
                    ->required()
                    ->placeholder('e.g., Software Engineer'),

                Textarea::make('tagline')
                    ->label('Hero Tagline / Subtitle')
                    ->required()
                    ->rows(4)
                    ->placeholder('Passionate about continuous learning...'),
            ]);
    }
}
