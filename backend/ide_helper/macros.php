<?php

namespace Illuminate\Http
{
    /**
     * @method mixed validate(array $rules, ...$params)
     * @see project://vendor/laravel/framework/src/Illuminate/Foundation/Providers/FoundationServiceProvider.php L148
     * @method mixed validateWithBag(string $errorBag, array $rules, ...$params)
     * @see project://vendor/laravel/framework/src/Illuminate/Foundation/Providers/FoundationServiceProvider.php L159
     * @method mixed hasValidSignature($absolute = true)
     * @see project://vendor/laravel/framework/src/Illuminate/Foundation/Providers/FoundationServiceProvider.php L177
     * @method mixed hasValidRelativeSignature()
     * @see project://vendor/laravel/framework/src/Illuminate/Foundation/Providers/FoundationServiceProvider.php L181
     * @method mixed hasValidSignatureWhileIgnoring($ignoreQuery = [], $absolute = true)
     * @see project://vendor/laravel/framework/src/Illuminate/Foundation/Providers/FoundationServiceProvider.php L185
     * @method mixed hasValidRelativeSignatureWhileIgnoring($ignoreQuery = [])
     * @see project://vendor/laravel/framework/src/Illuminate/Foundation/Providers/FoundationServiceProvider.php L189
     */
    class macros
    {
        /**
         * @param array $query The GET parameters
         * @param array $request The POST parameters
         * @param array $attributes The request attributes (parameters parsed from the PATH_INFO, ...)
         * @param array $cookies The COOKIE parameters
         * @param array $files The FILES parameters
         * @param array $server The SERVER parameters
         * @param resource|string|null $content The raw body data
         */
        public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null) {}
    }
}
