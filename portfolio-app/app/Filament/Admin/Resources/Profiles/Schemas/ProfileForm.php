<?php

namespace App\Filament\Admin\Resources\Profiles\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class ProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('bio')
                    ->label('About Me Biography')
                    ->required()
                    ->rows(8)
                    ->placeholder("Write your personal bio here.\n\nPress enter twice to start a new paragraph context dynamically!"),
  
            ]);
    }
}