# Skeleton for Slim
Estrutura básica para uso do microframework Slim usando padrão MVC.

Este repositório consiste em uma estrutura básica para o uso no desenvolvimento de aplicações usando o microframework Slim.

A estrutura dos diretórios estão separados da seguinte forma:

```
    - public
        - css
        - fonts
        - images
        - js
    - src
        - app
            - Controllers
            - Helpers
            - Middlewares
            - Models
            - Routes
            - Views
        - configs
        - system
            - Interfaces
```

No diretório ``public`` são encontrados os arquivos de folha de estilo, fonts, imagens e javascrip.

No diretorio ``src`` é onde estão os arquivos PHP.

* ``app`` está a estrutura MVC e outros arquivos como ``Helpers``, ``Middlewares`` e ``Routes``.
* ``configs`` aqui estão os arquivos de configurações do microframework Slim e configurações que possam ser usadas pelos sistemas desenvolvidos em cima dessa estrutura.
* ``system`` arquivos que organizam a estrutura para o uso do MVC.


#### O padrão MVC

O padrão MVC [Model, View, Controller] consiste organizar os arquivos da aplicação em três funções.

* ``Model`` é onde se encontra a lógica da aplicação. Aqui é onde é feita a filtragem dos dados, busca dos dados no Banco, organização dos dados, em fim o CRUD.
* ``View`` é onde estão os modelos/organização dos dados que serão mostrados para o usuário final.
* ``Controller`` nesses arquivos é onde é recebido as requisições (request) dos usuários e o mesmo pega os dados do ``Model`` e coloca em uma ``View`` e responde (response) para o requisitante.

##### Padrão dos arquivos do MVC

###### Model
Os arquivos do model devem seguir a seguinte estrutura:

```php
<?php

namespace App\Models;

use System\Model;
use Psr\Http\Message\RequestInterface;

class Usuarios extends Model
{
    public function __construct($container)
    {
        // Nome da tabela do banco de dados que será usado nesse model
        $table = 'usuarios';
        parent::__construct($container,$table);
    }
    
    public function index(RequestInterface $request)
    {
        // Definimos os dados que serão enviados para a página index
        $this->title = "Título da página";
        $this->content = "Conteúdo da página";
        
        // Retornamos os dados para que o Controller
        // possa repassa-los para a View
        return $this->data;
    }
}
```

###### View

As Views dessa estrutura usam o [Twig](https://twig.symfony.com/).

###### Controller

Os arquivos de Controller devem seguir a seguinte estrutura:

```php
<?php

namespace App\Controller;

use System\Controllers;

final class Home extends Controller
{
    public function __construct($container)
    {
        parent::__construct($container, 'Home', 'home');
        
        $this->template['index'] = 'index.twig';
    }
}
```
O metodo index ja está implementado pela classe pai.