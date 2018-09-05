<?php

namespace System\Interfaces;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ControllerInterface
{
    public function index(RequestInterface $request, ResponseInterface $Response);
    public function create(RequestInterface $request, ResponseInterface $Response);
    public function delete(RequestInterface $request, ResponseInterface $Response);
    public function update(RequestInterface $request, ResponseInterface $Response);
}