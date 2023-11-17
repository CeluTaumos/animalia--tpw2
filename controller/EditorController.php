
<?php
class AdminController
{
private $render;
private $model;

public function __construct($render, $model)
{
$this->render = $render;
$this->model = $model;
}

}