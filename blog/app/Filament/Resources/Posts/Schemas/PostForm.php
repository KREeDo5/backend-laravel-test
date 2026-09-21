<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Заголовок')
                    ->required()
                    ->maxLength(255),

                Select::make('author_id')
                    ->label('Автор')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Textarea::make('body')
                    ->label('Текст')
                    ->required()
                    ->columnSpanFull()
                    ->rows(10),
            ]);
    }
}
