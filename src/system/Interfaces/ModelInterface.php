<?php

namespace System\Interfaces;

use Psr\Http\Message\RequestInterface;

interface ModelInterface
{
    public function create(RequestInterface $request);
    public function delete(RequestInterface $request);
    public function update(RequestInterface $request);
}