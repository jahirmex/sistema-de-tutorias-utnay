<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# 🎓 Sistema de Tutorías (Laravel)

Sistema web desarrollado para la gestión de tutorías académicas entre alumnos, tutores y coordinadores.

---

## 🚀 Descripción

Este sistema permite administrar de forma eficiente las tutorías académicas dentro de una institución, facilitando la comunicación, seguimiento y control del desempeño de los alumnos.

Cuenta con autenticación, control de roles y dashboards personalizados para cada tipo de usuario.

---

## 👥 Roles del sistema

### 👨‍🎓 Alumno
- Ver sus tutorías
- Solicitar nuevas tutorías
- Consultar su tutor asignado
- Visualizar su rendimiento académico

### 👨‍🏫 Tutor
- Gestionar alumnos asignados
- Crear, editar y completar tutorías
- Consultar historial de sesiones
- Administrar su horario

### 🧑‍💼 Coordinador
- Administrar alumnos y tutores
- Generar reportes
- Supervisar el sistema completo

---

## ✨ Funcionalidades principales

- 🔐 Autenticación de usuarios
- 🧠 Sistema de roles (alumno, tutor, coordinador)
- 📊 Dashboard dinámico por rol
- 📅 Gestión completa de tutorías
- 🔔 Interfaz con notificaciones
- 🎨 UI moderna con Bootstrap 5
- ⚡ Sidebar dinámico y colapsable

---

## 📸 Capturas del sistema

### 🔐 Login
![Login](screenshots/captura_login.png)

### 👨‍🎓 Panel Alumno
![Panel Alumno](screenshots/captura_panelAlumno.png)

### 🧑‍💼 Panel Coordinador
![Panel Coordinador](screenshots/captura_panelCoordi.png)

### 👨‍🏫 Panel Tutor
![Panel Tutor](screenshots/captura_panelTutor.png)

### 📅 Gestión de Tutorías (Tutor)
![Tutorías Tutor](screenshots/captura_tutoriasTutor.png)

---

## 🛠️ Tecnologías utilizadas

- Laravel
- PHP
- MySQL
- Bootstrap 5
- JavaScript (Vanilla + SweetAlert2)

---

## ⚙️ Instalación

```bash
git clone https://github.com/tu-usuario/sistema-tutorias-laravel.git
cd sistema-tutorias-laravel

composer install
cp .env.example .env
php artisan key:generate

# Configura tu base de datos en .env

php artisan migrate
php artisan serve
```

---

## 🔑 Credenciales de prueba

```
Alumno:
jahir@utnay.edu.mx
12345678

Tutor:
tovar@utnay.edu.mx
12345678
silvia@utnay.edu.mx
12345678

Coordinador:
coordinador@utnay.edu.mx
12345678
```

---

## 🔐 Seguridad

- Middleware por roles
- Protección de rutas
- Control de acceso por tipo de usuario

---

## 📈 Estado del proyecto

🟢 En desarrollo activo

---

## 💼 Autor

Desarrollado por Jahir García 🚀

---

## ⭐ Si te gustó

No olvides dejar una estrella en el repositorio 🙌
