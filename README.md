# laravel-settings

Yet another but rather small library to implement cache-able settings into [Laravel](https://laravel.com/) projects, supports Laravel 5 and above.

### Installation

```bash
composer require vaibhavpandeyvpz/laravel-settings
```

#### Laravel < 5.5
Once the package is installed, open your `app/config/app.php` configuration file and locate the `providers` key.
Add the following line to the end:

```php
Laravel\Settings\SettingsServiceProvider::class
```

Next, locate the `aliases` key and add the following line:

```php
'Settings' => Laravel\Settings\SettingsFacade::class,
```

You can also publish the default configuration and migration using below command:

```bash
$ php artisan vendor:publish
```

### Usage

You can use either of `settings` helper or `Settings` facade to access the settings.

```php
# store a value
Settings::put('foo', 'bar');
settings(['foo' => 'bar']);
settings()->put('foo', 'bar');
settings('foo', 'bar');

settings()->put('foo', 'bar', false); // don't update in database yet
settings()->commit(); // save to database when you want

# retrieve a value
Settings::get('foo');
settings()->get('foo');
settings('foo');

# retrieve all values
Settings::all();
settings()->all();

# delete a value
Settings::forget('foo');
settings()->forget('foo');

settings()->forget('foo', false); // don't delete from database yet
settings()->commit(); // delete from database when you want
```

### Caching

The package can also cache stored settings for better performance.
To cache the settings, run below command:

```php
$ php artisan settings:cache
```

To clear cached settings anytime, use below command:

```php
$ php artisan settings:clear
```

### License

See [LICENSE](LICENSE) file.
