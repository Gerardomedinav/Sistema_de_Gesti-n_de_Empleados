# 🧑‍💼 Sistema de Gestión de Empleados

El **Sistema de Gestión de Empleados** es una aplicación web desarrollada con Laravel que permite gestionar empleados de manera sencilla y ordenada. Ofrece funcionalidades CRUD completas, validación de formularios, carga de imágenes y paginación. Ideal para pequeñas y medianas empresas.

---

## 📌 Funcionalidades principales

- ✅ Crear nuevos empleados con foto de perfil.
- ✏️ Editar información de empleados existentes.
- 🗑️ Eliminar empleados con seguridad.
- 📄 Ver todos los empleados en una lista paginada.
- 🔍 Validaciones de formulario con mensajes personalizados.
- 🖼️ Carga y visualización de imágenes.

---

## 📸 Vista previa del sistema

### 📋 Lista de empleados paginada
![Lista de empleados](./public/public/storage/uploads/captura1.png)

---

### ➕ Formulario para crear empleados
![Formulario de registro](./public/public/storage/uploads/captura2.png)

---

### 🛠️ Edición de empleados existentes
![Editar empleado](./public/public/storage/uploads/captura3.png)

---

## 🚀 Clonar y ejecutar el proyecto

### 1. Clonar el repositorio

```bash
git clone https://github.com/Gerardomedinav/Sistema_de_Gesti-n_de_Empleados.git
cd Sistema_de_Gesti-n_de_Empleados
```

### 2. Abrir en Visual Studio Code

```bash
code .
```

---

## ⚙️ Configuración e instalación

### 3. Instalar dependencias de Laravel

```bash
composer install
```

### 4. Instalar dependencias front-end

```bash
npm install
```

### 5. Configurar entorno

Copia el archivo `.env.example` y crea uno nuevo `.env`:

```bash
cp .env.example .env
php artisan key:generate
```

Editá tu archivo `.env` para conectar con tu base de datos:

```ini
DB_DATABASE=nombre_de_tu_bd
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 6. Ejecutar migraciones

```bash
php artisan migrate
```

### 7. Compilar recursos con Vite y Bootstrap

```bash
npm install bootstrap
npm run dev
```

---

## 🖥️ Iniciar servidor de desarrollo

```bash
php artisan serve
```

Accedé a la aplicación en:  
[http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🛠 Tecnologías utilizadas

- Laravel 10
- PHP 8.1+
- Vite
- Node.js
- Bootstrap 5
- MySQL
- HTML, CSS, JS

---

## 📬 Contacto

Desarrollado por **Gerardo Medina**  
🔗 GitHub: [Gerardomedinav](https://github.com/Gerardomedinav)  
📧 Email: gerardomedinavv@gmail.com

---


