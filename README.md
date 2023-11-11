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

Instancie a classe `Uplayer` especificando o diretório onde os arquivos irão 
após serem enviados por upload.

```php
require_once 'vendor/autoload.php';

use Uplayer\Uplayer;

$up = new Uplayer('DIRETORIO_DOS_ARQUIVOS');
```

## Como usar

### Upload de um único arquivo

Garanta que seu formulário esteja desta maneira:

```html
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="arquivo">
    <br><br><br> 
    <button type="submit">Upload</button>
</form>
```

No arquivo `upload.php`, utilize o método `UploadFile` para fazer o upload de um único arquivo. 
No parâmetro do método, passe o `name` do seu formulário.

```php
$res = $up->uploadFile('arquivo');

var_dump($res); //return `true`
```

Se o upload for feito sem nenhum problema, o método deverá retornar `true`.

### Upload de multiplos arquivos

Para fazer o upload de múltiplos arquivos, seu formulário deve estar desta maneira:

```html
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="arquivos[]" multiple>
    <br><br><br> 
    <button type="submit">Upload</button>
</form>
```

E no `upload.php`, use o método `uploadMultipleFiles` para fazer o upload de vários arquivos.

```php
$res = $up->uploadMultipleFiles('arquivos');

var_dump($res);
```

## Limitando as extensões dos arquivos

Caso queira realizar o upload de arquivos com extensões específicas, você poderá utilizar o segundo 
parâmetro como array, especificando os tipos de arquivos permitidos.

```php
$allowed_extensions = ['png', 'jpg'];

$up->uploadFile('arquivo', $allowed_extensions);
$up->uploadMultipleFiles('arquivos', $allowed_extensions);
```

## License

[MIT](https://github.com/brenno-duarte/uplayer/blob/master/LICENSE)
