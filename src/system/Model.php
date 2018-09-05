<?php

namespace System;

use Psr\Http\Message\RequestInterface;
use SlimSession\Helper;
use System\Interfaces\ModelInterface;

/**
 * Class Model
 * @package System
 */
class Model implements ModelInterface
{
    /**
     * @var object
     */
    protected $session;

    /**
     * @var int
     */
    public $page;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var object
     */
    protected $db;

    /**
     * @var object
     */
    protected $container;

    /**
     * Model constructor.
     *
     * @param $container
     * @param string $table
     */
    public function __construct($container, string $table)
    {
        $this->db = $container->db::table($table);
        $this->session = new Helper();
        $this->data['app_url'] = getenv('APP_URL');
        $this->data['app_title'] = getenv('APP_TITLE');
    }

    /**
     * @return array
     */
    public function __get($value)
    {
        if (in_array($value, $this->data)) {
            return $this->data[$value];
        }

        return null;
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Cria um registro no banco de dados
     *
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function create(RequestInterface $request)
    {
        if (false === $request->getAttribute('csrf_status')) {
            Message::alert('danger');
            return;
        }

        Message::alert($this->db->insert($this->filter($request))? 'success': 'danger');
        return;
    }

    /**
     * Retorna um registro do banco de dados baseado no id passado
     *
     * @param $id
     * @return mixed
     */
    public function find(RequestInterface $request)
    {
        $id = filter_var($request->getAttribute('route')->getArgument('id'), FILTER_SANITIZE_NUMBER_INT);

        return $this->db->where($this->table.'.id', $id)->get()[0];
    }

    /**
     * Atualiza um registro no banco de dados
     *
     * @param Request $request
     * @param Response $response
     * @return mixed|void
     */
    public function update(RequestInterface $request)
    {
        if (false === $request->getAttribute('csrf_status')) {
            Message::alert('danger');
            return;
        }

        $id = $request->getAttribute('route')->getArgument('id');

        Message::alert($this->db->where('id', $id)->update($this->filter($request))? 'success': 'danger');
        return;
    }

    /**
     * Apaga um registro no banco de dados baseado no id passado
     *
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    public function delete(RequestInterface $request)
    {
        $id = $request->getAttribute('route')->getArgument('id');

        Message::alert($this->db->where('id', $id)->delete()? 'success': 'danger');
        return;
    }

    /**
     * Calcula o offset para consulta no banco de dados
     *
     * @param Request $request
     * @return float|int
     */
    protected function offset(RequestInterface $request)
    {
        $this->page = $request->getAttribute('route')->getArgument('page');

        return $this->page <= 1? 0: ($this->page - 1) * getenv('APP_LIMIT_PAGINATION');
    }
}