## Filament Infolist - personalizando as páginas de visualização
Neste vídeo ensinaremos você a usar o Infolist, um módulo disponível na versão 3 do Filament que permite personalizar suas páginas de visualização de dados!

[Filament Infolist - personalizando as páginas de visualização](https://www.youtube.com/watch?v=p8FK4v86o2s)

[![Filament Infolist - personalizando as páginas de visualização](https://i3.ytimg.com/vi/p8FK4v86o2s/maxresdefault.jpg)](https://www.youtube.com/watch?v=p8FK4v86o2s)

## Installation

Clone the repo locally:

```sh
git clone https://github.com/filament-br/infolist-example.git infolist-example && cd infolist-example
```

Install PHP dependencies:

```sh
composer install
```

Setup configuration:

```sh
cp .env.example .env
```

Generate application key:

```sh
php artisan key:generate
```

Laravel sail:

```bash
sail up -d
```

Run database migrations:

```sh
sail artisan migrate --seed
```

Storage link:

```sh
sail artisan storage:link
```

## Usage

Once you have started the Artisan development server, your application will be accessible in your web browser at [http://localhost/admin](http://localhost/admin).

user: admin@example.com
password: _password_