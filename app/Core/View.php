<?php
namespace App\Core;

class View
{
    public static function render(string $view, array $data = [], ?string $layout = 'layouts/main')
    {
        extract($data, EXTR_SKIP);
        // Ensure $config is available in all views/layouts
        $config = $config ?? (require dirname(__DIR__, 2) . '/config/config.php');
        $viewFile = self::viewsPath() . '/' . $view . '.php';
        if (!file_exists($viewFile)) {
            echo "View not found: {$view}";
            return null;
        }
        ob_start();
        include $viewFile;
        $content = ob_get_clean();

        if ($layout !== null) {
            $layoutFile = self::viewsPath() . '/' . $layout . '.php';
            if (file_exists($layoutFile)) {
                include $layoutFile;
                return null;
            }
        }
        echo $content;
        return null;
    }

    public static function partial(string $partial, array $data = [])
    {
        extract($data, EXTR_SKIP);
        $partialFile = self::viewsPath() . '/' . $partial . '.php';
        if (file_exists($partialFile)) {
            include $partialFile;
        }
    }

    private static function viewsPath(): string
    {
        return dirname(__DIR__, 2) . '/views';
    }
}
