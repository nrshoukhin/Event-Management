<?php

class Controller {
    protected $loader;

    public function __construct() {
        $this->loader = new Loader();
    }

    public function view($view, $data = []) {
        extract($data);
        ob_start();
        include "application/views/{$view}.php";
        $content = ob_get_clean();
        include "application/views/layout.php";
    }


    public function model($model) {
        $modelPath = "application/models/{$model}.php";
        if (file_exists($modelPath)) {
            require_once $modelPath;
            return new $model();
        } else {
            echo "Error: Model '$model' not found.";
        }
    }
}
