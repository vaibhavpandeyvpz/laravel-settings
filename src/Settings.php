<?php

namespace Laravel\Settings;

use Illuminate\Filesystem\Filesystem;

class Settings
{
    /**
     * The added/updated settings array.
     *
     * @var array
     */
    protected $addedOrUpdated = [];

    /**
     * The deleted settings array.
     *
     * @var array
     */
    protected $deleted = [];

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
     * Persist the settings to the database.
     *
     * @param array|null $names
     */
    public function commit(?array $names = null)
    {
        $names = $names ?? array_keys($this->addedOrUpdated);
        foreach ($names as $name) {
            call_user_func([config('settings.model_class'), 'query'])
                ->updateOrCreate(compact('name'), ['value' => $this->settings['name'] ?? null]);
        }

        foreach ($this->deleted as $name) {
            call_user_func([config('settings.model_class'), 'query'])
                ->where('name', $name)
                ->delete();
        }

        $this->deleted = [];
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
     * @param bool $commit
     */
    public function put(string $name, $value, bool $commit = true)
    {
        $this->settings[$name] = $value;
        if ($commit) {
            $this->commit([$name]);
        } else {
            $this->addedOrUpdated[] = $name;
        }
    }

    /**
     * Delete a setting value.
     *
     * @param string $name
     * @param bool $commit
     */
    public function forget(string $name, bool $commit = true)
    {
        unset($this->settings[$name]);
        if ($commit) {
            call_user_func([config('settings.model_class'), 'query'])
                ->where('name', $name)
                ->delete();
        } else {
            $this->deleted[] = $name;
        }
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
