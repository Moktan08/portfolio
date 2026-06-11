<?php

namespace App\Filament\Admin\Resources\Education\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class EducationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('degree')
                    ->required()
                    ->placeholder('e.g., Bachelors in Software Engineering'),

                TextInput::make('institution')
                    ->required()
                    ->placeholder('e.g., Sichuan University'),

                TextInput::make('duration')
                    ->required()
                    ->placeholder('e.g., Oct 2016 – July 2020'),

                TextInput::make('location')
                    ->placeholder('e.g., Sichuan, China'),

                TextInput::make('key_modules')
                    ->required()
                    ->placeholder('e.g., Data Structures, Algorithms, Linear Algebra'),
            ]);
    }
}