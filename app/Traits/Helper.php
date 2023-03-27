<?php

namespace App\Traits;


use Illuminate\Support\Str;
use Spatie\LaravelIgnition\Support\Composer\ComposerClassMap;

trait Helper
{
    protected function isProduction()
    {
        return app()->environment('production');
    }

    public function getAvailableClasses($includedNamespace): array
    {
        $namespaces = array_keys((new ComposerClassMap)->listClasses());

        return array_filter($namespaces, function ($item) use ($includedNamespace) {
            return Str::startsWith($item, $includedNamespace);
        });
    }

    public static function replace_array_key(array &$item, $oldKey, $newKey): void
    {
        $item[$newKey] = $item[$oldKey];
        unset($item[$oldKey]);
    }
}
