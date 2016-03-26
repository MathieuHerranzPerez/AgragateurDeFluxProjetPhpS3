<?php

class Controller {
    public function model($model, $params) {
        require_once ROOT."php/models/".$model.".php";
        return new $model($params);
    }

    public function view($view, $data = []) {
        //todo display header
        require ROOT."php/views/".$view.'.php';
    }
}