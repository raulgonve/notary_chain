<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Descripcion General del Proyecto

NotaryChain es una plataforma de notaría digital descentralizada que utiliza la tecnología blockchain y la integración de Soulbound Tokens (SBT) para autenticar documentos y contratos de manera segura y verificables. Nuestro objetivo es modernizar y agilizar los servicios notariales, ofreciendo una solución que garantiza la autenticidad y la inmutabilidad de los documentos notariales.

* **Bounty Aplicado:** Begginers Bounty

## Instrucciones de Instalación

1. Clonar el repositorio en la carpeta de su servidor web local.
2. Crear una base de datos en MySQL.
3. Crear un archivo .env en la raíz del proyecto a partir del archivo .env.example.
4. Configurar las variables de entorno en el archivo .env. Las variables a configurar son las siguientes:
    - DB_CONNECTION=mysql
    - DB_HOST=
    - DB_PORT=
    - DB_DATABASE=
    - DB_USERNAME=
    - DB_PASSWORD=
5. Ejecutar el comando `composer install` en la raíz del proyecto.
6. Ejecutar el comando `php artisan key:generate` en la raíz del proyecto.
7. Ejecutar el comando `php artisan migrate` en la raíz del proyecto.
8. Ejecutar el comando `php artisan db:seed` en la raíz del proyecto.
9. Ejecutar el comando `php artisan serve` en la raíz del proyecto.
10. Ejecutar el comando `npm install` en la raíz del proyecto.
11. Ejecutar el comando `npm run dev` en la raíz del proyecto en otra ventana del terminal.
12. Acceder a la URL `http://localhost:8000` en su navegador web.

## Instrucciones de Uso

1. Iniciar sesión en la plataforma con las credenciales de usuario:
    - Correo electrónico: `usuario@notarychain.com`
    - Contraseña: `12345678`
2. En la página principal, se mostrarán los documentos notariales que ha creado.
3. Para crear un nuevo documento notarial, haga clic en el botón "Nuevo Documento".
4. Ingrese los datos del documento notarial y haga clic en el botón "Guardar".
5. El documento notarial se guardará en la plataforma y se mostrará en la página principal.
6. Para ver los detalles de un documento notarial, haga clic en el botón "Ver Detalles".
7. En la página de detalles, se mostrarán los datos del documento notarial y la información de autenticación.
8. Para autenticar un documento notarial, haga clic en el botón "Autenticar".
9. Ingrese el código de autenticación y haga clic en el botón "Verificar".
10. Se mostrará un mensaje indicando si el documento notarial es auténtico o no.


## Direcciones de Contratos Inteligentes

1. Contrato de Token Soulbound (SBT): [0xb45bc0526137372718ad271ed3c816b77526ebe9](https://sepolia.scrollscan.com/address/0xb45bc0526137372718ad271ed3c816b77526ebe9)
2. Txid de creación del contrato SBT: [0x6a324e8296707205913dd0af4866c5048d74c7414a1773a6028577d86fca13df](https://sepolia.scrollscan.com/tx/0x6a324e8296707205913dd0af4866c5048d74c7414a1773a6028577d86fca13df)

### Video demostrativo de la plataforma NotaryChain

[![NotaryChain](https://img.youtube.com/vi/1QJ9Q1Z9Z1A/0.jpg)](https://www.youtube.com/watch?v=1QJ9Q1Z9Z1A)

## Pitch deck

[Descargar pitch deck](https://drive.google.com/file/d/1QJ9Q1Z9Z1A/view?usp=sharing)
