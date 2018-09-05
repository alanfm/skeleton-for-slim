<?php

/**
 * @package App
 * @subpackage Libraries\Bootstrap
 */
namespace App\Helpers\Bootstrap;

/**
 * @dependences HTMLBuilder\ElementFactory
 */
use HTMLBuilder\ElementFactory as Element;

/**
 * @class Pagination
 *
 * Interface para criação de paginação em html e
 * framework css Bootstrap
 *
 * @author Alan Freire <alan_freire@msn.com>
 * @version 2.0
 * @copyright MIT 2017 Alan Freire
 */
final class Pagination
{
    /**
     * @var HTMLBuilfer\Element
     * @access private
     *
     * Recebe um Elemento HTML
     */
    private static $ul;

    /**
     * @var intger
     * @access private
     *
     * Recebe o tamanho da lista
     */
    private static $limit;

    /**
     * @var string
     * @access private
     *
     * Recebe o uri para os links
     */
    private static $uri;

    /**
     * @var integer
     * @access private
     *
     * Recebe a quantidade de itens no centro da lista
     * sendo a quantidade de links antes da selecionada + 1
     */
    private static $count_li = 4;

    /**
     * @method render()
     * @access public
     *
     * Cria um código HTML de uma lista para paginação
     *
     * @param integer $count
     * Total de registros a serem paginados
     *
     * @param integer $current
     * Página atual
     *
     * @param string $uri
     * Uri para criação dos links
     *
     * @return string
     * Código HTML gerado para a paginação
     */
    public static function render(int $count, int $current, string $uri)
    {
        // Seta a quantidade de registro por página
        self::$limit = ceil($count / getenv('APP_LIMIT_PAGINATION'));

        // Seta a uri do app
        self::$uri = $uri;

        // Cria a tag ul
        $ul = Element::make('ul')->attr('class', ['pagination', 'pagination-sm']);

        // Adiciona a seta de voltar
        $ul->value(self::previous($current));

        $i = self::firstPageIterator($current);
        do {
            if (self::$limit < 3) {
                break;
            }

            $li = Element::make('li');

            if (($i + 1) == $current) {
                $li->attr('class', ['active', 'page-item'])->value(self::link($i + 1, null, true));
            } else {
                $li->attr('class', ['page-item'])->value(self::link($i + 1));
            }

            $ul->value($li);

            $i++;
        } while ($i < self::lastPageIterator($current));

        // Adiciona a seta de avançar
        $ul->value(self::next($current));

        return Element::make('nav')->attr('aria-label', ['navigation'])->value($ul)->render();
    }

    /**
     * @method previous
     * @access private
     *
     * Cria os primeiros elementos da lista para paginação
     *
     * @param integer $count
     * Total de registro a serem paginados
     *
     * @param integer $current
     * Página atual
     *
     * @return array
     * Primeira página e seta para página aterior
     */
    private static function previous(int $current)
    {
        $text = Element::make('span')->attr('aria-hidden', ["true"])->value('&#9665;');
        $li = Element::make('li')->attr('class', ['page-item']);

        if ($current <= 1) {
            return [$li->attr('class', ['disabled', 'page-item'])->value(self::link('', $text, true)), self::firstLi($current)];
        }

        return [$li->value(self::link($current - 1, $text)), self::firstLi($current)];
    }

    /**
     * @method firstLi()
     * @access private
     *
     * Cria o primeiro item da lista
     * e o deixa fixo no início junto com a seta para
     * voltar a página, inserindo também as reticenças
     * caso seja necessário
     *
     * @param integer $current
     * Página atual
     *
     * @return mix
     * Array                Primeira página e reticenças caso necessário
     * HTMLBuilder\Element  Link da primeira página
     */
    private static function firstLi(int $current)
    {
        $li = Element::make('li')->attr('class', ['page-item'])->value(self::link(1));

        if ($current == 1) {
            return $li->attr('class', ['active', 'page-item']);
        }

        if ((self::firstPageIterator($current) + self::$count_li) > (self::$count_li + 1)) {
            return [$li, self::reticence()];
        }

        return $li;
    }

    /**
     * @method next()
     * @access private
     *
     * Adiciona os elementos do final da lista de links da pagináção
     *
     * @param integer $current
     * Página atual
     *
     * @return array
     * Ultima página e seta para proxima página
     */
    private static function next(int $current)
    {
        $text = Element::make('span')->attr('aria-hidden', ['true'])->value('&#9655;');
        $li = Element::make('li')->attr('class', ['page-item']);

        if ($current >= self::$limit) {
            return [self::lastLi($current), $li->attr('class', ['disabled', 'page-item'])->value(self::link('', $text, true))];
        }

        return [self::lastLi($current), $li->value(self::link($current + 1, $text))];
    }

    /**
     * @method lastLi()
     * @access private
     *
     * Cria o ultimo item da lista
     * e o deixa fixo no final junto com a seta para
     * avançar a página, inserindo também as reticenças
     * caso seja necessário
     *
     * @param integer $current
     * Página atual
     *
     * @return mix
     * Array                Ultima página e reticenças caso necessário
     * HTMLBuilder\Element  Link da ultima página
     */
    private static function lastLi(int $current)
    {
        if (self::$limit == 1) {
            return;
        }

        $li = Element::make('li')->attr('class', ['page-item'])->value(self::link(self::$limit));

        if ($current == self::$limit) {
            return $li->attr('class', ['active', 'page-item']);
        }

        if ((self::lastPageIterator($current) + self::$count_li) <= (self::$limit + 2)) {
            return [self::reticence(), $li];
        }

        return $li;
    }

    /**
     * @method firstPageIterator
     * @access private
     *
     * Calcula em que página o enlace deve começar
     *
     * @param integer $current
     * Página atual
     *
     * @return interger
     * Valor onde o enlace interno deve começar
     */
    private static function firstPageIterator(int $current)
    {
        if (($current - self::$count_li) > 0) {
            return $current - self::$count_li;
        }

        return self::$limit == 1? null: 1;
    }

    /**
     * @method lastPageIterator
     * @access private
     *
     * Calcula até que página o enlace deve ir
     *
     * @param $current
     * Página atual
     *
     * @return integer
     * Valor onde o enlace interno deve encerrar
     */
    private static function lastPageIterator(int $current)
    {
        if (($current + self::$count_li) < self::$limit) {
            return ($current + self::$count_li) - 1;
        }

        return self::$limit > 1? self::$limit - 1: 1;
    }

    /**
     * @method reticence
     *
     * Cria uma li com reticenças
     *
     * @return InterfaceElements
     * Item com reticenças
     */
    private static function reticence()
    {
        return Element::make('li')->attr('class',['disabled', 'page-item'])->value(self::link('', '...', true));
    }

    /**
     * @method link
     * @access private
     *
     * Cria um elemento de link
     *
     * @param string $page
     * Página do link e seu valor
     *
     * @param mix $text
     * Valor que será mostrado para o lin
     *
     * @param boolean $disabled
     * True caso o link não tenha efeito
     * False por padrão
     *
     * @return HTMLBuilder\Element
     * Elemento de ancora/link do HTML
     */
    private static function link(string $page, $text = null, bool $disabled = false)
    {
        $a = Element::make('a')->attr('href', [$disabled? 'javascript:void()': getenv('URL_BASE').self::$uri.'/'.$page])
            ->attr('class', ['page-link']);
        if ($disabled) {
            $a->attr('tabindex',['-1']);
        }
        if ($text == null) {
            return $a->value($page);
        }

        return $a->value($text);
    }
}