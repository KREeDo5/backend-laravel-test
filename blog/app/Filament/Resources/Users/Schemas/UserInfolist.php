<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Профиль')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Имя'),

                        TextEntry::make('email')
                            ->label('E-mail')
                            ->copyable(),

                        IconEntry::make('is_admin')
                            ->label('Администратор')
                            ->boolean(),

                        TextEntry::make('created_at')
                            ->label('Зарегистрирован')
                            ->dateTime('d.m.Y H:i'),
                    ]),
            ]);
    }
}
