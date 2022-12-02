<?php

namespace Laravel\Settings;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed get(string $name)
 * @method static void put(string $name, $value)
 * @method static void forget(string $name)
 * @method static array all()
 */
class SettingsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Settings::class;
    }
}
