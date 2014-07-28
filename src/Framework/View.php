<?php
namespace Framework;

class View
{
    protected $paths;

    public function __construct(array $paths)
    {
        $this->paths = $paths;
    }

    public function render($template, $parameters)
    {
        ob_start();
        extract($parameters, EXTR_SKIP);

        foreach ($this->paths as $path) {
            if (file_exists("$path/$template")) {
                require "$path/$template";
                break;
            }
        }

        return ob_get_clean();
    }
}