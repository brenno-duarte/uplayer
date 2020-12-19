<p align="center">
  <a href="https://github.com/brenno-duarte/uplayer/releases"><img alt="GitHub release (latest by date)" src="https://img.shields.io/github/v/release/brenno-duarte/uplayer?style=flat-square"></a>
  <a href="https://github.com/brenno-duarte/uplayer/blob/master/LICENSE"><img alt="GitHub" src="https://img.shields.io/github/license/brenno-duarte/uplayer?style=flat-square"></a>
</p>

## Sobre

Componente PHP para realizar o upload de arquivos

## Instalação via Composer

```
composer require brenno-duarte/uplayer
```

## Inicializando

```php
require_once 'vendor/autoload.php';

use Uplayer\Uplayer;

$up = new Uplayer('DIRETORIO_DOS_ARQUIVOS');
```

## Como usar

### Upload de um único arquivo

Garanta que seu formulário esteja desta maneira.

```html
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="arquivo">
    <br><br><br> 
    <button type="submit">Upload</button>
</form>
```

No arquivo `upload.php`, utilize o método `UploadFile`.

O primeiro parâmetro representa o `name` do formulário. O segundo contém um array com as extensões permitidas.

```php
$res = $up->uploadFile('arquivo');

var_dump($res);
```

### Upload de multiplos arquivos

Seu formulário deve estar desta maneira.

```html
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="arquivos[]" multiple>
    <br><br><br> 
    <button type="submit">Upload</button>
</form>
```

E no `upload.php`.

```php
$res = $up->uploadMultipleFiles('arquivos');

var_dump($res);
```

## Limitando as extensões dos arquivos

Caso queira realizar o upload de apenas alguns tipos de arquivos, você poderá utilizar o segundo parâmetro como array, especificando os tipos de arquivos permitidos.

```php
$up->uploadFile('arquivo', ['png', 'jpg']);

$up->uploadMultipleFiles('arquivos', ['png', 'jpg']);
```

## Nomes únicos para cada arquivo

Para gerar nomes únicos para cada arquivo, você poderá passar `true` no último parâmetro.

```php
$up->uploadFile('arquivo', null, true);

$up->uploadMultipleFiles('arquivos', null, true);
```

## License

[MIT](https://github.com/brenno-duarte/uplayer/blob/master/LICENSE)
