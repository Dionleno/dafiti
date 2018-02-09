# Lumen PHP Framework

Projeto Api Proxy com o framework Lumen.

## Instalação

Baixar o repositorio:
```
git clone https://github.com/Dionleno/dafiti.git
```

## Atualizar as dependencias
```
composer update
```

## Rodar aplicação
```
php -S localhost:8000 -t public
```

## Rotas da api

 ### Listar cervejas
 http://localhost:8000/v2/beers
 
 ### Aplicar filtros
 http://localhost:8000/v2/beers/filter?{tipo}={valor}&{tipo}={valor} [....] (Podem adicionar N filtros)
 Exemplo: http://localhost:8000/v2/beers/filter?ibu_gt=4&ibu_gt=2
 tipo de filtro a ser aplicado (abv_gt, abv_lt, ibu_gt, ibu_lt, ebc_gt, ebc_lt, beer_name)
 
 ### Busca randomica
 http://localhost:8000/v2/beers/random
 
 ### Paginação
 http://localhost:8000/v2/beers/page/{page}/{per_page}
 Exemplo: http://localhost:8000/v2/beers/page/2/25
 Obs: Caso a variavel per_page não for definida o default é 20 itens
 
 ### Single Beer => buscar por ID
 http://localhost:8000/v2/beer/{id}
 
 
 
