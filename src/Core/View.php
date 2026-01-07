<?php

namespace App\Core;

class View
{
    protected string $layout = 'main';

    public static function render(string $view, array $data = [])
    {
        $instance = new self();

        // Check if custom layout is specified
        if (isset($data['layout'])) {
            $instance->layout = $data['layout'];
        }

        return $instance->renderView($view, $data);
    }

    public function renderView(string $viewPath, array $data = []): string
    {
        $settings = [];
        try {
            $settings = \App\Models\Setting::getAllGrouped();
        } catch (\Throwable $e) {
            $settings = [];
        }

        $data['settings'] = $settings;

        try {
            $data['csrf_token'] = (new \App\Security\SecurityManager())->generateCsrfToken();
        } catch (\Throwable $e) {
            $data['csrf_token'] = null;
        }

        // Extract data to variables
        extract($data);

        // Buffer the view content
        ob_start();

        // Try pages directory first, then root views directory
        $viewFile = __DIR__ . '/../../views/pages/' . $viewPath . '.php';
        if (!file_exists($viewFile)) {
            $viewFile = __DIR__ . '/../../views/' . $viewPath . '.php';
        }

        if (file_exists($viewFile)) {
            require $viewFile;
        } else {
            echo "Görünüm [$viewPath] bulunamadı";
        }
        $content = ob_get_clean();

        // Render layout
        ob_start();
        $layoutFile = __DIR__ . '/../../views/layouts/' . $this->layout . '.php';
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
        return ob_get_clean();
    }
}
