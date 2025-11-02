# 🚗 Proyecto Aventones – Plataforma de Compartición de Viajes

## 📋 Objetivo
Desarrollar habilidades en **programación de aplicaciones web** mediante la implementación de un sistema completo que gestione usuarios, vehículos, viajes (rides) y reservas, reforzando los conocimientos adquiridos en clase.

---

## 🧩 Descripción General
**Aventones** es una aplicación web diseñada para conectar **choferes** y **pasajeros** mediante la creación y reserva de viajes compartidos.  
Incluye un **panel administrativo**, un proceso de **registro con verificación por correo**, y una **página pública de búsqueda de rides**.

---

## 👥 Tipos de Usuario
El sistema contempla **tres tipos de usuarios**, divididos en dos categorías principales:

| Tipo | Descripción | Permisos principales |
|------|--------------|----------------------|
| 🧑‍💼 Administrador | Gestiona el sistema | Crear otros administradores, activar/desactivar usuarios |
| 🚗 Chofer | Ofrece viajes (rides) | Crear, editar, eliminar vehículos y rides |
| 🧍 Pasajero | Solicita viajes | Buscar rides, realizar reservas, cancelar reservas |

---

## 🔐 Autenticación y Registro
- Los usuarios **choferes y pasajeros** se registran desde la pantalla de **Login**, completando un formulario con:
  - Nombre, Apellido  
  - Cédula  
  - Fecha de nacimiento  
  - Correo electrónico  
  - Teléfono  
  - Fotografía personal  
  - Contraseña (y confirmación)
- Tras registrarse, su cuenta queda en **estado “Pendiente”**.
- Se envía un **correo electrónico de verificación** con un enlace de activación.
- Solo los usuarios con **estado “Activo”** pueden acceder al sistema.
- Si el usuario está **Pendiente o Inactivo**, se mostrará un mensaje indicativo.

---

## 🚙 Gestión de Vehículos (Chofer)
Los choferes pueden gestionar su flota personal:
- Crear, editar y eliminar vehículos.
- Cada vehículo contiene:
  - Número de placa  
  - Color, marca, modelo, año  
  - Capacidad de asientos  
  - Fotografía del automotor  
- Los vehículos solo son visibles para su propietario.

---

## 🛣️ Gestión de Rides (Chofer)
Cada ride (viaje) incluye:
- Nombre del ride  
- Lugar de salida y llegada  
- Día y hora  
- Costo por espacio  
- Cantidad de espacios disponibles  
- Vehículo asociado  

El chofer puede:
- Crear, editar y eliminar sus rides.
- Visualizar todos sus rides registrados.

---

## 🎟️ Reservas (Pasajero)
- Los pasajeros pueden **buscar rides públicos** y **realizar reservas**.
- Choferes y pasajeros pueden **ver sus reservas activas y pasadas**.
- Choferes pueden **Aceptar o Rechazar** solicitudes.
- Pasajeros pueden **Cancelar** solicitudes **pendientes o aceptadas**.

---

## 🌍 Página Pública – Búsqueda de Rides
- Cualquier visitante puede ver los rides disponibles, mostrando:
  - Lugar de salida y llegada  
  - Fecha y hora  
  - Vehículo (marca, modelo y año)  
  - Espacios disponibles  
- La lista se muestra **ordenada por fecha/hora del viaje (del más próximo al más futuro)**.
- Incluye una función de **ordenamiento ascendente/descendente** por:
  - Fecha
  - Lugar de origen
  - Lugar de destino
- Solo los usuarios **registrados como pasajeros** pueden realizar reservas.

---

## ⚙️ Script Automatizado (CLI)
El proyecto incluye un **script ejecutable desde consola (PHP CLI)**:

### 🧠 Función
- Identifica todas las **solicitudes de reserva** con más de **X minutos** desde su creación que aún **no han sido aceptadas o rechazadas**.
- Envía un **correo electrónico de notificación** a los choferes con reservas pendientes.

### 📦 Ejemplo de ejecución
```bash
php validatePendingReservations.php 30
