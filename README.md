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