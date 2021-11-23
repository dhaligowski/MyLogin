
<?php
// spl_autoload_register(function ($classname) {
//     // require_once $classname . '.php';
//     require_once str_replace('\\', '/', $classname) . '.php';
// });


spl_autoload_register(function ($Class) {
    $Path = __DIR__ . '/' . strtolower($Class) . '.php';
    if (!file_exists($Path)) {
        exit("Something went wrong!");
    }
    require_once $Path;
});
