<?php

namespace Laravel\Settings;

use Illuminate\Filesystem\Filesystem;

class Settings
{
    /**
     * The settings array.
     *
     * @var array
     */
    protected $settings = [];

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct(Filesystem $filesystem)
    {
        $cache = config('settings.cache_path');
        if ($filesystem->exists($cache)) {
            $this->settings = require $cache;
        } else {
            $this->settings = call_user_func([config('settings.model_class'), 'query'])
                ->orderBy('name')
                ->pluck('value', 'name')
                ->toArray();
        }
    }

    /**
     * Get a setting value.
     *
     * @param string $name
     * @return mixed
     */
    public function get(string $name)
    {
        return $this->settings[$name] ?? null;
    }

    /**
     * Set a setting value.
     *
     * @param string $name
     * @param mixed $value
     */
    public function put(string $name, $value)
    {
        call_user_func([config('settings.model_class'), 'query'])
            ->updateOrCreate(compact('name'), compact('value'));
        $this->settings[$name] = $value;
    }

    /**
     * Delete a setting value.
     *
     * @param string $name
     */
    public function forget(string $name)
    {
        unset($this->settings[$name]);
        call_user_func([config('settings.model_class'), 'query'])
            ->where('name', $name)
            ->delete();
    }

    /**
     * Get all settings.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->settings;
    }
}
