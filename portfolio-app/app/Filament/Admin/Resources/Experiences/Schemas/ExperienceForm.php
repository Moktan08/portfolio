<?php

namespace App\Filament\Admin\Resources\Experiences\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class ExperienceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('position')
                    ->required()
                    ->placeholder('e.g., Web Development Intern'),

                TextInput::make('company')
                    ->required()
                    ->placeholder('e.g., SunCaper'),

                TextInput::make('duration')
                    ->required()
                    ->placeholder('e.g., Apr 2020 – July 2020'),

                TextInput::make('location')
                    ->placeholder('e.g., Sichuan, China'),

                Textarea::make('responsibilities')
                    ->required()
                    ->rows(5)
                    ->placeholder("Enter each bullet point on a brand new line.\nLine 2\nLine 3"),
            ]);
    }
}