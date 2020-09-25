<?php

declare(strict_types=1);

/**
 * @author    : Jagepard <jagepard@yandex.ru">
 * @license   https://mit-license.org/ MIT
 */

namespace Rudra\View;

use Rudra\Container\Traits\{FacadeTrait, SetRudraContainersTrait};

class View extends AbstractView
{
    use FacadeTrait;
    use ViewTrait;
    use SetRudraContainersTrait;

    private array $template;

    protected function template(array $config): void
    {
        switch ($config["engine"]) {
            case "native":
                $this->template = $config;
                break;
        }
    }

    protected function view(string $path, array $data = []): string
    {
        $path = $this->rudra()->config()->get("bp") . "{$this->template["view.path"]}/"
            . str_replace('.', '/', $path) .
            ".{$this->template["file.extension"]}";

        ob_start();

        if (count($data)) extract($data, EXTR_REFS);
        if (file_exists($path)) require_once $path;

        return ob_get_clean();
    }

    protected function render(string $path, array $data = [])
    {
        echo $this->view($path, $data);
    }
}
