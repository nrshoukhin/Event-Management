<?php

class Loader {
    public function view($view, $data = []) {
        $viewFile = "application/views/{$view}.php";
        if (file_exists($viewFile)) {
            extract($data);
            require $viewFile;
        } else {
            echo "Error: View file '{$view}' not found.";
        }
    }

    public function model($model) {
        $modelFile = "application/models/{$model}.php";
        if (file_exists($modelFile)) {
            require_once $modelFile;
            if (class_exists($model)) {
                return new $model();
            } else {
                echo "Error: Model class '{$model}' not found.";
            }
        } else {
            echo "Error: Model file '{$model}' not found.";
        }
    }
}
