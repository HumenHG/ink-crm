# Ink CRM · Multi-estudio

CRM de citas para estudios de tatuaje. PHP 8.1+ y MySQL/MariaDB. Cada estudio tiene su propio login y sus datos aislados; un super admin crea y administra los estudios.

## Instalación
1. Crea una base de datos MySQL y sube todo el contenido a la raíz de tu dominio (o subcarpeta).
2. Edita `config/config.local.php` con tus datos de base de datos y una `setup_key` larga.
3. Abre `https://tudominio.com/setup.php?key=TU_SETUP_KEY` (o `php setup.php` por consola). Crea las tablas y los usuarios de prueba.
4. **Borra `setup.php`**, cambia las contraseñas de prueba y activa HTTPS (descomenta el bloque en `.htaccess`).
5. Da permisos de escritura a `uploads/logos/` y `storage/`.

## Usuarios de prueba (cámbialos al terminar)
| Rol | Entrada | Usuario | Contraseña |
|---|---|---|---|
| Super admin | `/` | `superadmin` | `Ink-Super-2026!` |
| Estudio demo | `/?e=demo` | `demo` | `Ink-Demo-2026!` |

El super admin entra por la misma pantalla y llega a `/admin/`. Ahí crea estudios (nombre, logo, usuario y contraseña, o se generan), los suspende, restablece contraseñas o los elimina. Cada estudio tiene su enlace `/?e=slug` con su logo.

## Seguridad incluida
Contraseñas con `password_hash`, sesiones httpOnly/SameSite, CSRF en formularios y API, consultas preparadas, límite de intentos de login, aislamiento por `studio_id`, logos validados y sin ejecución de PHP en `uploads/`, cabeceras CSP.

## Subir a GitHub (repositorio nuevo)
```bash
cd ink-crm
git init && git add . && git commit -m "Ink CRM multi-estudio"
git branch -M main
git remote add origin https://github.com/TU_USUARIO/NOMBRE_DEL_REPO.git
git push -u origin main
```
`config/config.local.php` está en `.gitignore`: no se sube.
