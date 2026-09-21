<?php

namespace App\Enums;

/**
 * Варианты сортировки публикаций.
 */
enum PostSort: string
{
    /** По заголовку: А → Я */
    case TitleAsc = 'title_asc';

    /** По заголовку: Я → А */
    case TitleDesc = 'title_desc';

    /** По дате создания: ранее созданные → созданные позже */
    case DateAsc = 'date_asc';

    /** По дате создания: созданные позже → ранее созданные */
    case DateDesc = 'date_desc';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::TitleAsc => 'А → Я',
            self::TitleDesc => 'Я → А',
            self::DateAsc => 'Ранее созданные → Созданные позже',
            self::DateDesc => 'Созданные позже → Ранее созданные',
        };
    }
}