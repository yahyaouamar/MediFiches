<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class CustomValidationRulesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Validator::extend('requires_tetanos_update', function ($attribute, $value, $parameters, $validator) {
            // Your custom logic here
            // Example: Check if tetanos_protected is not null
            $tetanosProtectedValue = $validator->getData()['tetanos_update'] ?? null;
            return $tetanosProtectedValue !== null;
        });
        Validator::replacer('requires_tetanos_update', function ($message, $attribute, $rule, $parameters) {
            // Customize the error message for requires_tetanos_update rule
            return str_replace(':attribute', $attribute, 'Must indicate last tetanos vaccination date!');
        });
        Validator::extend('requires_tetanos_protected', function ($attribute, $value, $parameters, $validator) {
            // Your custom logic here
            // Example: Check if tetanos_protected is not null
            $tetanosProtectedValue = $validator->getData()['tetanos_protected'] ?? null;
            return $tetanosProtectedValue !== null;
        });
        Validator::replacer('requires_tetanos_protected', function ($message, $attribute, $rule, $parameters) {
            // Customize the error message for requires_tetanos_update rule
            return str_replace(':attribute', $attribute, 'Must check the tetanos vaccinated checkbox!');
        });
    }
}
