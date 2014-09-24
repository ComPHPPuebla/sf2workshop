<?php
namespace Framework\View;

use RuntimeException;

class PhpEngine implements TemplateEngine
{
    protected $paths;
    protected $templateFound;

    /**
     * @param array $paths
     */
    public function __construct(array $paths)
    {
        $this->paths = $paths;
        $this->templateFound = false;
    }

    /**
     * @param  string $template
     * @param  array  $parameters
     * @return string
     */
    public function render($template, array $parameters = [])
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
