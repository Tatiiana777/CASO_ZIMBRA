# CRM Zimbra — Plataforma Full-Stack de Gestión Comercial

Sistema CRM/ERP full-stack desarrollado con **React, PHP y MySQL** para la gestión integral de procesos comerciales, marketing, ventas y reportes empresariales.

---

# Descripción del Proyecto

CRM Zimbra es una plataforma empresarial diseñada para centralizar y automatizar el flujo comercial de una organización, permitiendo gestionar:

* Leads y campañas de marketing
* Seguimientos comerciales
* Propuestas y ventas
* Pedidos y facturación
* Pagos y reportes analíticos
* Usuarios, roles y auditoría

El sistema implementa una arquitectura modular desacoplada basada en:

* **Frontend:** React
* **Backend:** PHP + API REST
* **Base de Datos:** MySQL
* **Comunicación:** JSON REST

---

# Arquitectura del Sistema

```text
Frontend React
      ↓
API REST PHP
      ↓
CRUDs / Modelos
      ↓
MySQL
```

---

# Tecnologías Utilizadas

## Frontend

* React
* JavaScript
* CSS3
* Hooks (`useState`, `useEffect`, `useMemo`)

## Backend

* PHP
* Programación Orientada a Objetos (POO)
* API REST
* PDO
* JSON

## Base de Datos

* MySQL
* Procedimientos almacenados
* Triggers
* Vistas SQL
* Funciones SQL
* Transacciones ACID

---

# Funcionalidades Principales

## CRM Comercial

* Gestión de leads
* Seguimientos
* Conversión de clientes
* Gestión de campañas

## ERP Comercial

* Productos y proveedores
* Propuestas comerciales
* Pedidos
* Facturación
* Pagos

## Administración

* Usuarios y roles
* Control de permisos
* Auditoría de acciones

## Analítica

* Dashboard comercial
* Reportes SQL
* Métricas de conversión

---

# Módulos del Sistema

## Marketing

* Campañas
* Leads
* Seguimientos

## Comercial

* Propuestas
* Productos y servicios
* Pedidos

## Financiero

* Facturas
* Pagos
* Reportes

## Administrativo

* Usuarios
* Roles
* Empresas
* Auditoría

---

# Características Técnicas

## Arquitectura Modular

Cada entidad posee:

* Modelo
* CRUD
* Serialización JSON
* Integración API REST

## Seguridad

* Prepared Statements con PDO
* Prevención de SQL Injection
* Manejo de excepciones

## Automatización

* Generador automático de entidades y CRUDs
* Triggers SQL
* Procedimientos almacenados

## Escalabilidad

El sistema permite agregar nuevas entidades dinámicamente mediante generación automática de código.

---

# Flujo Empresarial

```text
Campaña
   ↓
Lead
   ↓
Seguimiento
   ↓
Propuesta
   ↓
Pedido
   ↓
Factura
   ↓
Pago
```

---

# Propiedades ACID Implementadas

El sistema utiliza transacciones SQL para garantizar:

* Atomicidad
* Consistencia
* Aislamiento
* Durabilidad

Ejemplos:

* Registro de ventas
* Generación de facturas
* Operaciones financieras

---

# Triggers Implementados

Ejemplos de automatización:

* Conversión automática de leads
* Actualización de estados comerciales
* Registro de auditoría
* Validaciones automáticas

---

# Procedimientos Almacenados

Ejemplos:

* Reporte mensual de ventas
* Tasa de conversión comercial
* Dashboard comercial
* Reportes analíticos

---

# Estructura del Proyecto

```text
CRM-Zimbra/
│
├── backend/
│   ├── api.php
│   ├── conexion.php
│   ├── *_crud.php
│   ├── *.php
│   └── zimbra.sql
│
├── frontend/
│   ├── components/
│   ├── services/
│   ├── App.jsx
│   └── App.css
│
└── README.md
```

---

# Instalación

## 1. Clonar repositorio

```bash
git clone https://github.com/usuario/crm-zimbra.git
```

---

## 2. Backend

### Configurar `.env`

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=caso_zimbra
DB_USER=root
DB_PASS=
```

### Importar base de datos

Importar:

```text
zimbra.sql
```

en MySQL.

---

## 3. Frontend

Instalar dependencias:

```bash
npm install
```

Ejecutar:

```bash
npm run dev
```

---

# Usuarios Demo

```text
Administrador
admin@zimbra.com / 12345

Ventas
ventas@zimbra.com / 12345

Marketing
marketing@zimbra.com / 12345
```

---

# Roles del Sistema

| Rol           | Permisos                 |
| ------------- | ------------------------ |
| Administrador | Control total            |
| Ventas        | Gestión comercial        |
| Marketing     | Visualización y campañas |

---

# Autores

Proyecto desarrollado para la asignatura de Arquitectura de Software.

Integrantes:

* Johan Sebastián
* Equipo CRM Zimbra

---

# Conclusión

CRM Zimbra implementa una solución empresarial moderna basada en arquitectura modular, automatización SQL y tecnologías full-stack, permitiendo gestionar procesos comerciales completos de manera eficiente, escalable y organizada.
