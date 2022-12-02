<?php

if (!function_exists('settings')) {
    /**
     * @param string|array|null $name
     * @param mixed $value
     * @return Laravel\Settings\Settings|mixed
     */
    function settings($name = null, $value = null)
    {
        /** @var Laravel\Settings\Settings $settings */
        $settings = app('settings');
        if ($name === null) {
            return $settings;
        } else if (is_array($name)) {
            foreach ($name as $key => $value) {
                $settings->put($key, $value);
            }
        } else if (is_string($name)) {
            if (count(func_get_args()) === 2) {
                $settings->put($name, $value);
            } else {
                return $settings->get($name);
            }
        }
    }
}
