<?php
//$configCacheKey = 'cli';
$siteConfig = array(
    'modules' => array(
        'Application',
    ),
);

$globPaths = array(
    __DIR__ . '/autoload/{,*.}{global,local}.php',
);

return array_replace_recursive(
    array(
        'module_listener_options'   => array(
            'config_glob_paths'     => $globPaths,
            'config_cache_enabled'  => false,
            'module_paths'          => array(
                './module',
                './vendor',
            ),
        ),
    ),
    $siteConfig
);
