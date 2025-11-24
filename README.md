# 🔐 Sistema de Autenticación de Dos Factores (2FA)

## 🧩 Tecnologías Utilizadas

  ------------------------- ------------------------------------------------------------------------------------------------------------- -----------------------------
  **PHP 7.4+**              ![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)                                      Lenguaje principal del
                                                                                                                                          sistema

  **Apache / Nginx**        ![Apache](https://img.shields.io/badge/Apache-D22128?logo=apache&logoColor=white)                             Servidor web recomendado
                            ![Nginx](https://img.shields.io/badge/Nginx-009639?logo=nginx&logoColor=white)                                

  **Google Authenticator**  ![GA](https://img.shields.io/badge/Google%20Authenticator-4285F4?logo=google-authenticator&logoColor=white)   Para escanear QR y generar
                                                                                                                                          códigos TOTP

  **php-gd**                🖼️                                                                                                            Extensión necesaria para
                                                                                                                                          generar códigos QR
  ---------------------------------------------------------------------------------------------------------------------------------------------------------------------

------------------------------------------------------------------------

## 📄 Descripción General

Un sistema completo y profesional de **Autenticación en Dos Factores
(2FA)** basado en **TOTP**, compatible con Google Authenticator.

Incluye:

-   🔑 Validación TOTP\
-   🧩 Generación de QR\
-   🔒 Manejo seguro de sesiones\
-   📦 Estructura limpia y escalable\
-   🛠️ Integración fácil en cualquier proyecto PHP

------------------------------------------------------------------------

## 🔑 Datos de Acceso (Demo)

| Campo | Acceso |
|-------|--------|
| **Correo** | `admin@localhost.com` |
| **Contraseña** | `12345` |


------------------------------------------------------------------------

## 📂 Estructura del Proyecto

  -----------------------------------------------------------------------
  Carpeta / Archivo                         Descripción
  ----------------------------------------- -----------------------------
  `/assets/`                                Archivos estáticos: CSS, JS,
                                            imágenes

  `/includes/`                              Funciones internas, lógica
                                            2FA y configuración

  `/vendor/`                                Librerías externas (📌
                                            *descomprimir `phpqrcode.zip`
                                            aquí*)

  `index.php`                               Login + activación 2FA

  `admin.php`                               Panel protegido (requiere
                                            2FA)

  `logout.php`                              Cierre seguro de sesión
  -----------------------------------------------------------------------

⚠️ **IMPORTANTE:** La carpeta `/vendor/` contiene `phpqrcode.zip`, el
cual **debe ser descomprimido** antes de usar el sistema.

------------------------------------------------------------------------

## 🔐 Funcionalidades

  Función                                 Estado
  --------------------------------------- --------
  Generación de código QR                 ✔️
  Validación de código TOTP               ✔️
  Manejo de sesiones seguras              ✔️
  Compatibilidad con apps Authenticator   ✔️
  Código claro y documentado              ✔️

------------------------------------------------------------------------

## 🚀 Requisitos

  Requisito                 Necesario
  ------------------------- -----------
  PHP 7.4+                  ✔️
  Extensión php-gd          ✔️
  Servidor Apache o Nginx   ✔️
  Composer (opcional)       ✔️

------------------------------------------------------------------------

## ⚙️ Instalación

### 1️⃣ Clonar el repositorio

``` bash
git clone https://github.com/LuisHauMoran/login-2fa
```

### 2️⃣ Preparar dependencias

-   Verifica que `/vendor/` **existe**\
-   Asegúrate de **descomprimir `phpqrcode.zip`**

Si usas Composer:

``` bash
composer install
```

### 3️⃣ Configuración

Modifica `/includes/` según tu proyecto.

### 4️⃣ Iniciar el servidor

``` bash
php -S localhost:8000
```

### 5️⃣ Abrir en el navegador

    http://localhost:8000

------------------------------------------------------------------------

## 🧪 Flujo de Uso

  Paso   Acción
  ------ ----------------------------------------------
  1      Abrir `index.php`
  2      Escanear el QR con Google Authenticator
  3      Ingresar el código TOTP
  4      Acceder a `admin.php` si el código es válido

------------------------------------------------------------------------

## ❤️ Apoya el Proyecto

Si deseas colaborar:

👉 **PayPal:** https://www.paypal.com/paypalme/luishaumoran

------------------------------------------------------------------------

## 📄 Licencia

MIT License.

------------------------------------------------------------------------

# English Version

## 📄 Description

A complete and professional PHP implementation of Two-Factor
Authentication (2FA) using TOTP, compatible with Google Authenticator.

------------------------------------------------------------------------

## 🔑 Demo Login Credentials

| Fields | Data |
|--------|--------|
| **Email** | `admin@localhost.com` |
| **Password** | `12345` |


------------------------------------------------------------------------

## 📂 Project Structure

  Folder         Description
  -------------- -------------------------------------------------------
  `/assets/`     Static files
  `/includes/`   System logic
  `/vendor/`     External libraries (**extract `phpqrcode.zip` here**)
  `index.php`    Login + 2FA
  `admin.php`    Protected page
  `logout.php`   Logout

------------------------------------------------------------------------

## 🔐 Features

-   QR code generation\
-   TOTP validation\
-   Secure session handling\
-   Easy integration

------------------------------------------------------------------------

## 🚀 Requirements

  Requirement           Needed
  --------------------- --------
  PHP 7.4+              ✔️
  php-gd                ✔️
  Apache / Nginx        ✔️
  Composer (optional)   ✔️

------------------------------------------------------------------------

## ⚙️ Installation

``` bash
git clone https://github.com/LuisHauMoran/login-2fa
composer install
php -S localhost:8000
```

------------------------------------------------------------------------

## ❤️ Support

👉 PayPal: https://www.paypal.com/paypalme/luishaumoran

------------------------------------------------------------------------

## 📄 License

MIT License.
