<?php
namespace Framework;

use RuntimeException;

class View
{
    protected $paths;
    protected $templateFound;

    public function __construct(array $paths)
    {
        $this->paths = $paths;
        $this->templateFound = false;
    }

    public function render($template, $parameters)
    {
        ob_start();
        extract($parameters, EXTR_SKIP);

        foreach ($this->paths as $path) {
            if (file_exists("$path/$template")) {
                $this->templateFound = true;
                require "$path/$template";

                break;
            }
        }

        if (!$this->templateFound) {
            throw new RuntimeException(
                sprintf(
                    'Template "%s" cannot be found in paths: %s',
                    $template,
                    implode(', ', $this->paths)
                )
            );
        }

        return ob_get_clean();
    }
}