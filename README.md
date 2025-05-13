Elevator App

Projeto desenvolvido em Laravel que realiza simulação de funcionamento de elevador.

Instalação e Execução

- Clone o repositório

Configuração do ambiente:

- Certifique-se de ter o Docker instalado.
- Execute `./vendor/bin/sail up -d`

Acesse o container do PHP:

- `docker exec -it elevator-app-laravel.test-1 bash`

Rode o comando para elevador:simular para iniciar a simulação:

- Execute o comando `php artisan elevador:simular` dentro do container

Execução de testes:

- Execute o comando `php artisan test` dentro do container
