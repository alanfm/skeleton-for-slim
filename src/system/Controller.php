<?php

namespace System;

use System\Interfaces\ControllerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Controller implements ControllerInterface
{
    protected $template;

    protected $container;

    protected $data;

    protected $model;

    protected $page;

    public function __construct($container, $model, $page)
    {
        $this->container = $container;
        $model = sprintf("App\Model\%s", ucfirst($model));
        $this->model = new $model($container);
        $this->page = strtolower($page);
    }

    public function __get($value)
    {
        if (!isset($this->container[$value])) {
            return null;
        }

        return $this->container[$value];
    }

    public function create(RequestInterface $request, ResponseInterface $response)
    {
        $this->model->create($request);

        return $response->withRedirect($this->page);
    }

    public function update(RequestInterface $request, ResponseInterface $response)
    {
        $this->model->update($request);

        return $response->withRedirect($this->page);
    }

    public function delete(RequestInterface $request, ResponseInterface $response)
    {
        $this->model->delete($request);

        return $response->withRedirect($this->page);
    }   

    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return $this->view->render($response, $this->template['index'], $this->model->index($request));
    }

    public function edit(RequestInterface $request, ResponseInterface $response)
    {
        return $this->view->render($response, $this->template['index'], $this->model->edit($request));
    }
}