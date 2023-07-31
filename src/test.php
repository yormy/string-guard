<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class test extends Command
{
    protected $signature = 'test';

    const DEFAULT_INCLUDE = true;

    public function handle(): void
    {
       // self::defaultInclude();
        self::includeAll();
        //self::excludeAll();

        echo "done". PHP_EOL;
    }

    private static function defaultInclude()
    {
        $config = [
            'include' => [
                UrlFilter::config('a*', ['post', 'delete']),
            ],
            'exclude' => [
                UrlFilter::config('b', ['post', 'delete']),
            ]
        ];

        $shouldInclude = [
            'included_post.com' => ['post'],
            'included_postwild.com' => ['post']
        ];

        $result = self::testIncludeExclude($shouldInclude, $config, true);
        self::report($result, __FUNCTION__);
    }


    private static function includeAll()
    {
        $config = [
            'include' => [
                UrlFilter::config('include*', ['post', 'delete']),
            ],
            'exclude' => [
            ]
        ];

        $shouldInclude = [
            'included_post.com' => ['post'],
            'included_postwild.com' => ['post']
        ];

        $result = self::testIncludeExclude($shouldInclude, $config, true);
        dd($result);
        self::report($result, __FUNCTION__);
    }

    private static function excludeAll()
    {
        $config = [
            'include' => [
                UrlFilter::config('*', ['post', 'delete']),
            ],
            'exclude' => [
                UrlFilter::config('*'),
            ]
        ];

        $shouldExclude = [
            'excluded_post.com' => ['post'],
        ];

        $result = self::testExcludes($shouldExclude, $config);
        self::report($result, __FUNCTION__);
    }



    private static function report($result, string $function)
    {
        if (!empty($result['errors'])) {
            echo "--------- $function ---------";
            dd($result);
        };
    }

    private static function testing()
    {
        $config = [
            'include' => [
                UrlFilter::config('included_post.com', ['post', 'delete']),
                UrlFilter::config('included_postwild*', ['post', 'delete']),
                UrlFilter::config('included_delete.com', ['post', 'delete'], ['fields' => 'kkkk']),
            ],
            'exclude' => [
                UrlFilter::config('excluded_post.com', ['post', 'delete']),
                UrlFilter::config('excluded_delete.com', ['post', 'delete'], ['fields' => 'kkkk']),
                UrlFilter::config('included_post.com/excluded', ['post', 'delete']),
            ]
        ];

        $shouldInclude = [
            'included_post.com' => ['post'],
            'included_postwild.com' => ['post']
        ];

        $shouldExclude = [
//            'excluded_post.com' => ['post'],
//            'excluded_delete.com' => ['post'],
            'included_post.com/excluded' => ['get'] // wrong
        ];

        $includeErrors = [];
        //$includeErrors = self::testIncludes($shouldInclude, $config);

        $excludeErrors = self::testExcludes($shouldExclude, $config);
        dd($excludeErrors);

//
//        echo "INCLUDE OK". PHP_EOL;
//        foreach ($includeOk as $message) {
//            echo $message;
//        }

        echo PHP_EOL;
        echo "INCLUDE ERRORS". PHP_EOL;
        foreach ($includeErrors as $message) {
            echo $message;
        }

        echo PHP_EOL;
        echo "EXCLUDE ERRORS". PHP_EOL;
        foreach ($excludeErrors as $message) {
            echo $message;
        }

        echo PHP_EOL;
    }

    private static function testIncludeExclude(array $shouldInclude, array $config, $expectedInclude = false): array
    {
        $errors = [];
        $okes = [];
        foreach ($shouldInclude as $url => $methods) {
            foreach ($methods as $method) {
                $included = UrlFilter::isIncluded($url, $method, $config, self::DEFAULT_INCLUDE);

                if ($expectedInclude) {
                    $message = "Expect Include: ";
                } else {
                    $message = "Expect Exclude: ";
                }

                if ($included === $expectedInclude) {
                    $okes[] = "$message $url $method". PHP_EOL;
                } else {
                    $errors[] = "$message $url $method". PHP_EOL;
                }
            }
        }

        return [
            'ok' => $okes,
            'errors' => $errors
        ];
    }


//
//
//
//
//    private static function testExcludes(array $shouldInclude, array $config): array
//    {
//        $errors = [];
//        $okes = [];
//        foreach ($shouldInclude as $url => $methods) {
//            foreach ($methods as $method) {
//                $included = UrlFilter::isIncluded($url, $method, $config, self::DEFAULT_INCLUDE);
//                if (!$included) { // change
//                    $okes[] = "excluded: $url $method". PHP_EOL;
//                } else {
//                    $errors[] = "Should be excluded: $url $method". PHP_EOL;
//                }
//            }
//        }
//
//        return [
//            'ok' => $okes,
//            'errors' => $errors
//        ];
//    }
//
//    private static function testIncludes(array $shouldInclude, array $config): array
//    {
//        $errors = [];
//        $okes = [];
//        foreach ($shouldInclude as $url => $methods) {
//            foreach ($methods as $method) {
//                $included = UrlFilter::isIncluded($url, $method, $config, self::DEFAULT_INCLUDE);
//                if ($included) {
//                    $okes[] = "Included: $url $method" . PHP_EOL;
//                } else {
//                    $errors[] = "Should be included: $url $method". PHP_EOL;
//                }
//            }
//        }
//
//        return [
//            'ok' => $okes,
//            'errors' => $errors
//        ];
//    }
}
