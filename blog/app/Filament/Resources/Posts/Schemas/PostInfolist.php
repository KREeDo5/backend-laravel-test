<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Filament\Resources\Users\UserResource;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Публикация')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('title')
                            ->label('Заголовок'),

                        TextEntry::make('author.name')
                            ->label('Автор')
                            ->color('primary')
                            ->url(fn ($record): ?string => $record->author
                                ? UserResource::getUrl('view', ['record' => $record->author])
                                : null),

                        TextEntry::make('created_at')
                            ->label('Создана')
                            ->dateTime('d.m.Y H:i'),

                        TextEntry::make('updated_at')
                            ->label('Обновлена')
                            ->dateTime('d.m.Y H:i'),

                        TextEntry::make('body')
                            ->label('Текст')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
