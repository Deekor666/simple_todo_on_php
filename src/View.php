<?php

namespace App;

use InvalidArgumentException;

class View
{
    private string $templatePath = '/views';

    public function render(string $templateName, array $data = [])
    {
        $templatePath = __DIR__ . $this->templatePath . '/' . $templateName . '.php';

        if (!file_exists($templatePath)) {
            throw new InvalidArgumentException(sprintf('Template "%s" not found', $templateName));
        }

        extract($data);
        ob_start();
        include_once 'views/templates/header.php';
        include_once 'views/templates/errors.php';
        include $templatePath;
        include_once 'views/templates/footer.php';

        $content = ob_get_clean();
        echo $content;
    }

}