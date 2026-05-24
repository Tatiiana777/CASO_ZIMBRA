
USE BZIMBRA;


-- NÚCLEO
CREATE TABLE Empresa (
    id_empresa     INT           AUTO_INCREMENT PRIMARY KEY,
    nombre         VARCHAR(100)  NOT NULL,
    nit            VARCHAR(30)   NOT NULL UNIQUE,
    direccion      VARCHAR(150),
    telefono       VARCHAR(20),
    sector         VARCHAR(80),
    fecha_registro DATETIME      DEFAULT NOW()
);

CREATE TABLE Rol (
    id_rol      INT          AUTO_INCREMENT PRIMARY KEY,
    nombre_rol  VARCHAR(50)  NOT NULL,
    descripcion VARCHAR(150)
);

CREATE TABLE Usuario (
    id_usuario     INT           AUTO_INCREMENT PRIMARY KEY,
    id_empresa     INT           NOT NULL,
    id_rol         INT           NOT NULL,
    nombre         VARCHAR(100)  NOT NULL,
    correo         VARCHAR(120)  NOT NULL UNIQUE,
    contrasena     VARCHAR(255)  NOT NULL,
    telefono       VARCHAR(20),
    activo         TINYINT       DEFAULT 1
                   CONSTRAINT CHK_Usuario_activo CHECK (activo IN (0,1)),
    fecha_creacion DATETIME      DEFAULT NOW(),
    CONSTRAINT FK_Usuario_Empresa
        FOREIGN KEY (id_empresa) REFERENCES Empresa(id_empresa),
    CONSTRAINT FK_Usuario_Rol
        FOREIGN KEY (id_rol) REFERENCES Rol(id_rol)
);

CREATE TABLE Auditoria (
    id_auditoria   INT           AUTO_INCREMENT PRIMARY KEY,
    id_usuario     INT           NOT NULL,
    accion         VARCHAR(100)  NOT NULL,
    tabla_afectada VARCHAR(60),
    fecha          DATETIME      DEFAULT NOW(),
    descripcion    TEXT,
    CONSTRAINT FK_Auditoria_Usuario
        FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

-- BLOQUE CRM
CREATE TABLE Marketing (
    id_marketing   INT           AUTO_INCREMENT PRIMARY KEY,
    id_empresa     INT           NOT NULL,
    nombre         VARCHAR(100)  NOT NULL,
    descripcion    TEXT,
    presupuesto    DECIMAL(12,2) DEFAULT 0.00,
    fecha_creacion DATETIME      DEFAULT NOW(),
    CONSTRAINT FK_Marketing_Empresa
        FOREIGN KEY (id_empresa) REFERENCES Empresa(id_empresa)
);

CREATE TABLE Campania (
    id_campania  INT           AUTO_INCREMENT PRIMARY KEY,
    id_marketing INT           NOT NULL,
    id_usuario   INT           NOT NULL,
    nombre       VARCHAR(120)  NOT NULL,
    descripcion  TEXT,
    fecha_inicio DATE          NOT NULL,
    fecha_fin    DATE,
    costo        DECIMAL(12,2) DEFAULT 0.00,
    estado       VARCHAR(20)   NOT NULL DEFAULT 'planificada'
                 CONSTRAINT CHK_Campania_estado
                 CHECK (estado IN ('planificada','activa',
                                   'pausada','finalizada')),
    CONSTRAINT FK_Campania_Marketing
        FOREIGN KEY (id_marketing) REFERENCES Marketing(id_marketing),
    CONSTRAINT FK_Campania_Usuario
        FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);


CREATE TABLE `Lead` (

    id_lead         INT           AUTO_INCREMENT PRIMARY KEY,
    id_campania     INT           NOT NULL,
    id_usuario      INT           NOT NULL,
    nombre          VARCHAR(100)  NOT NULL,
    empresa         VARCHAR(100),
    correo          VARCHAR(120),
    telefono        VARCHAR(20),
    pais            VARCHAR(60),

    estado_contacto VARCHAR(30)   NOT NULL DEFAULT 'prospecto',

                    CONSTRAINT CHK_Lead_estado
                    CHECK (estado_contacto IN (
                        'prospecto','en_seguimiento',
                        'propuesta_enviada','convertido','perdido')),
    fecha_registro  DATETIME      DEFAULT NOW(),
    CONSTRAINT FK_Lead_Campania
        FOREIGN KEY (id_campania) REFERENCES Campania(id_campania),
    CONSTRAINT FK_Lead_Usuario
        FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Seguimiento (
    id_seguimiento  INT          AUTO_INCREMENT PRIMARY KEY,
    id_lead         INT          NOT NULL,
    id_usuario      INT          NOT NULL,
    fecha           DATETIME     DEFAULT NOW(),
    canal           VARCHAR(40)  NOT NULL
                    CONSTRAINT CHK_Seguimiento_canal

                    CHECK (canal IN ('llamada','correo','reunion','demo','otro')),

    resultado       VARCHAR(60),
    proxima_accion  DATE,
    notas           TEXT,
    CONSTRAINT FK_Seguimiento_Lead

        FOREIGN KEY (id_lead) REFERENCES `Lead`(id_lead),

    CONSTRAINT FK_Seguimiento_Usuario
        FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

-- BLOQUE COMERCIAL
CREATE TABLE Proveedor (
    id_proveedor INT           AUTO_INCREMENT PRIMARY KEY,
    id_empresa   INT           NOT NULL,
    nombre       VARCHAR(100)  NOT NULL,
    nit          VARCHAR(30)   UNIQUE,
    telefono     VARCHAR(20),
    correo       VARCHAR(120),
    direccion    VARCHAR(150),
    activo       TINYINT       DEFAULT 1
                 CONSTRAINT CHK_Proveedor_activo CHECK (activo IN (0,1)),
    CONSTRAINT FK_Proveedor_Empresa
        FOREIGN KEY (id_empresa) REFERENCES Empresa(id_empresa)
);

CREATE TABLE Producto_Servicio (
    id_producto  INT            AUTO_INCREMENT PRIMARY KEY,
    id_proveedor INT            NOT NULL,
    nombre       VARCHAR(120)   NOT NULL,
    descripcion  TEXT,
    precio_base  DECIMAL(12,2)  NOT NULL
                 CONSTRAINT CHK_Producto_precio CHECK (precio_base >= 0),
    stock        INT            NOT NULL DEFAULT 0
                 CONSTRAINT CHK_Producto_stock CHECK (stock >= 0),
    activo       TINYINT        DEFAULT 1
                 CONSTRAINT CHK_Producto_activo CHECK (activo IN (0,1)),
    CONSTRAINT FK_Producto_Proveedor
        FOREIGN KEY (id_proveedor) REFERENCES Proveedor(id_proveedor)
);

CREATE TABLE Propuesta (
    id_propuesta   INT            AUTO_INCREMENT PRIMARY KEY,
    id_lead        INT            NOT NULL,
    id_usuario     INT            NOT NULL,
    fecha_creacion DATETIME       DEFAULT NOW(),
    fecha_vigencia DATETIME       NOT NULL,
    valor_total    DECIMAL(12,2)  DEFAULT 0.00,
    estado         VARCHAR(20)    NOT NULL DEFAULT 'borrador'
                   CONSTRAINT CHK_Propuesta_estado
                   CHECK (estado IN ('borrador','enviada',
                                     'aceptada','rechazada','vencida')),
    observaciones  TEXT,
    CONSTRAINT FK_Propuesta_Lead

        FOREIGN KEY (id_lead) REFERENCES `Lead`(id_lead),

    CONSTRAINT FK_Propuesta_Usuario
        FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);

CREATE TABLE Detalle_Propuesta (
    id_detalle      INT            AUTO_INCREMENT PRIMARY KEY,
    id_propuesta    INT            NOT NULL,
    id_producto     INT            NOT NULL,
    cantidad        INT            NOT NULL
                    CONSTRAINT CHK_DetProp_cantidad CHECK (cantidad > 0),
    precio_unitario DECIMAL(12,2)  NOT NULL
                    CONSTRAINT CHK_DetProp_precio CHECK (precio_unitario >= 0),
    descuento       DECIMAL(5,2)   DEFAULT 0.00,
    subtotal DECIMAL(12,2) AS (cantidad * precio_unitario *
         (1 - descuento / 100)) STORED,
    CONSTRAINT FK_DetProp_Propuesta
        FOREIGN KEY (id_propuesta) REFERENCES Propuesta(id_propuesta),
    CONSTRAINT FK_DetProp_Producto
        FOREIGN KEY (id_producto) REFERENCES Producto_Servicio(id_producto)
);

-- BLOQUE ERP
CREATE TABLE Cliente (
    id_cliente       INT           AUTO_INCREMENT PRIMARY KEY,
    id_empresa       INT           NOT NULL,
    id_lead          INT           NULL,
    nombre           VARCHAR(100)  NOT NULL,
    apellido         VARCHAR(100),
    documento        VARCHAR(30)   NOT NULL UNIQUE,
    telefono         VARCHAR(20),
    correo           VARCHAR(120),
    fecha_conversion DATETIME      DEFAULT NOW(),
    CONSTRAINT FK_Cliente_Empresa
        FOREIGN KEY (id_empresa) REFERENCES Empresa(id_empresa),
    CONSTRAINT FK_Cliente_Lead

        FOREIGN KEY (id_lead) REFERENCES `Lead`(id_lead)

);

CREATE TABLE Cliente_Campania (
    id_cliente     INT   NOT NULL,
    id_campania    INT   NOT NULL,
    fecha_contacto DATE  NOT NULL,
    estado         VARCHAR(50),
    CONSTRAINT PK_Cliente_Campania
        PRIMARY KEY (id_cliente, id_campania),
    CONSTRAINT FK_CC_Cliente
        FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente),
    CONSTRAINT FK_CC_Campania
        FOREIGN KEY (id_campania) REFERENCES Campania(id_campania)
);

CREATE TABLE Empleado (
    id_empleado  INT           AUTO_INCREMENT PRIMARY KEY,
    id_usuario   INT           NULL,
    id_empresa   INT           NOT NULL,
    nombre       VARCHAR(100)  NOT NULL,
    cargo        VARCHAR(80),
    telefono     VARCHAR(20),
    correo       VARCHAR(120),
    CONSTRAINT FK_Empleado_Usuario
        FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario),
    CONSTRAINT FK_Empleado_Empresa
        FOREIGN KEY (id_empresa) REFERENCES Empresa(id_empresa)
);

CREATE TABLE Pedido (
    id_pedido    INT          AUTO_INCREMENT PRIMARY KEY,
    id_cliente   INT          NOT NULL,
    id_empleado  INT          NOT NULL,
    id_propuesta INT          NULL,
    fecha        DATE         NOT NULL,
    estado       VARCHAR(50)  NOT NULL DEFAULT 'Pendiente'
                 CONSTRAINT CHK_Pedido_estado
                 CHECK (estado IN ('Pendiente','En proceso',
                                   'Entregado','Cancelado')),
    CONSTRAINT FK_Pedido_Cliente
        FOREIGN KEY (id_cliente) REFERENCES Cliente(id_cliente),
    CONSTRAINT FK_Pedido_Empleado
        FOREIGN KEY (id_empleado) REFERENCES Empleado(id_empleado),
    CONSTRAINT FK_Pedido_Propuesta
        FOREIGN KEY (id_propuesta) REFERENCES Propuesta(id_propuesta)
);

CREATE TABLE Detalle_Pedido (
    id_detalle      INT            AUTO_INCREMENT PRIMARY KEY,
    id_pedido       INT            NOT NULL,
    id_producto     INT            NOT NULL,
    cantidad        INT            NOT NULL
                    CONSTRAINT CHK_DetPed_cantidad CHECK (cantidad > 0),
    precio_unitario DECIMAL(12,2)  NOT NULL
                    CONSTRAINT CHK_DetPed_precio CHECK (precio_unitario >= 0),
    subtotal DECIMAL(12,2) AS (cantidad * precio_unitario) STORED,
    CONSTRAINT FK_DetPed_Pedido
        FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido),
    CONSTRAINT FK_DetPed_Producto
        FOREIGN KEY (id_producto) REFERENCES Producto_Servicio(id_producto)
);

CREATE TABLE Factura (
    id_factura    INT            AUTO_INCREMENT PRIMARY KEY,
    id_pedido     INT            NOT NULL UNIQUE,
    fecha_emision DATE           NOT NULL,
    total         DECIMAL(12,2)  NOT NULL
                  CONSTRAINT CHK_Factura_total CHECK (total >= 0),
    estado        VARCHAR(20)    NOT NULL DEFAULT 'pendiente'
                  CONSTRAINT CHK_Factura_estado
                  CHECK (estado IN ('pendiente','pagada','anulada')),
    CONSTRAINT FK_Factura_Pedido
        FOREIGN KEY (id_pedido) REFERENCES Pedido(id_pedido)
);

CREATE TABLE Pago (
    id_pago      INT            AUTO_INCREMENT PRIMARY KEY,
    id_factura   INT            NOT NULL,
    fecha_pago   DATE           NOT NULL,
    metodo_pago  VARCHAR(50)    NOT NULL
                 CONSTRAINT CHK_Pago_metodo
                 CHECK (metodo_pago IN ('Transferencia','Tarjeta',
                                        'Efectivo','Crédito')),
    valor        DECIMAL(12,2)  NOT NULL
                 CONSTRAINT CHK_Pago_valor CHECK (valor > 0),
    CONSTRAINT FK_Pago_Factura
        FOREIGN KEY (id_factura) REFERENCES Factura(id_factura)
);

CREATE TABLE Reporte (
    id_reporte        INT          AUTO_INCREMENT PRIMARY KEY,
    id_usuario        INT          NOT NULL,
    tipo_reporte      VARCHAR(60)  NOT NULL
                      CONSTRAINT CHK_Reporte_tipo
                      CHECK (tipo_reporte IN (
                          'campanas','conversiones',
                          'rendimiento_vendedor','propuestas',
                          'ingresos','inventario')),
    periodo_inicio    DATE,
    periodo_fin       DATE,
    fecha_generacion  DATETIME     DEFAULT NOW(),
    observaciones     TEXT,
    CONSTRAINT FK_Reporte_Usuario
        FOREIGN KEY (id_usuario) REFERENCES Usuario(id_usuario)
);


-- ROLES
INSERT INTO Rol (nombre_rol, descripcion) VALUES
('administrador', 'Acceso total al sistema'),
('vendedor',      'Gestión de leads, seguimientos y propuestas'),
('supervisor',    'Consulta de reportes y aprobación de propuestas');

-- EMPRESAS (30)
INSERT INTO Empresa (nombre, nit, direccion, telefono, sector) VALUES
('Apple Inc.','900100001','One Apple Park Way, Cupertino, CA','+1-408-996-1010','Tecnología'),
('Microsoft Corporation','900100002','One Microsoft Way, Redmond, WA','+1-425-882-8080','Tecnología'),
('Google LLC','900100003','1600 Amphitheatre Pkwy, Mountain View, CA','+1-650-253-0000','Tecnología'),
('Amazon.com Inc.','900100004','410 Terry Ave N, Seattle, WA','+1-206-266-1000','Comercio'),
('Meta Platforms Inc.','900100005','1 Hacker Way, Menlo Park, CA','+1-650-543-4800','Tecnología'),
('IBM Corporation','900100006','1 New Orchard Rd, Armonk, NY','+1-914-499-1900','Tecnología'),
('Oracle Corporation','900100007','2300 Oracle Way, Austin, TX','+1-737-867-1000','Tecnología'),
('Samsung Electronics','900100008','Samsung Town, Seoul, South Korea','+82-2-2255-0114','Electrónica'),
('Sony Corporation','900100009','Konan, Minato City, Tokyo, Japan','+81-3-6748-2111','Electrónica'),
('Dell Technologies','900100010','One Dell Way, Round Rock, TX','+1-512-338-4400','Tecnología'),
('HP Inc.','900100011','1501 Page Mill Rd, Palo Alto, CA','+1-650-857-1501','Tecnología'),
('Lenovo Group','900100012','Morrisville, North Carolina, USA','+1-855-253-6686','Tecnología'),
('Cisco Systems','900100013','170 W Tasman Dr, San Jose, CA','+1-408-526-4000','Redes'),
('Intel Corporation','900100014','2200 Mission College Blvd, Santa Clara, CA','+1-408-765-8080','Semiconductores'),
('NVIDIA Corporation','900100015','2788 San Tomas Expy, Santa Clara, CA','+1-408-486-2000','Semiconductores'),
('Adobe Inc.','900100016','345 Park Ave, San Jose, CA','+1-408-536-6000','Software'),
('Salesforce Inc.','900100017','415 Mission St, San Francisco, CA','+1-415-901-7000','Software'),
('SAP SE','900100018','Dietmar-Hopp-Allee 16, Walldorf, Germany','+49-6227-747474','Software'),
('Siemens AG','900100019','Werner-von-Siemens-Str. 1, Munich, Germany','+49-89-636-00','Industrial'),
('LG Electronics','900100020','LG Twin Towers, Seoul, South Korea','+82-2-3777-1114','Electrónica'),
('Xiaomi Corporation','900100021','Haidian District, Beijing, China','+86-10-6060-6666','Tecnología'),
('Huawei Technologies','900100022','Longgang District, Shenzhen, China','+86-755-2878-0808','Telecomunicaciones'),
('Tesla Inc.','900100023','3500 Deer Creek Rd, Palo Alto, CA','+1-650-681-5000','Automotriz'),
('Netflix Inc.','900100024','100 Winchester Cir, Los Gatos, CA','+1-408-540-3700','Entretenimiento'),
('Spotify AB','900100025','Regeringsgatan 19, Stockholm, Sweden','+46-8-123-456','Entretenimiento'),
('Uber Technologies','900100026','1515 3rd St, San Francisco, CA','+1-415-612-8582','Transporte'),
('Airbnb Inc.','900100027','888 Brannan St, San Francisco, CA','+1-415-728-0100','Hospitalidad'),
('PayPal Holdings','900100028','2211 North First St, San Jose, CA','+1-408-967-1000','Fintech'),
('Visa Inc.','900100029','900 Metro Center Blvd, Foster City, CA','+1-650-432-3200','Fintech'),
('Mastercard Inc.','900100030','2000 Purchase St, Purchase, NY','+1-914-249-2000','Fintech');

-- USUARIOS (10)
INSERT INTO Usuario
    (id_empresa, id_rol, nombre, correo, contrasena, telefono)
VALUES
(1,1,'Admin Principal','admin@zimbra.com',
    SHA2('Admin2026!',256),'+57-3000000001'),
(2,2,'Carlos Vendedor','carlos.v@zimbra.com',
    SHA2('Vendedor2026!',256),'+57-3000000002'),
(3,2,'Laura Vendedora','laura.v@zimbra.com',
    SHA2('Vendedor2026!',256),'+57-3000000003'),
(4,3,'Pedro Supervisor','pedro.s@zimbra.com',
    SHA2('Super2026!',256),'+57-3000000004'),
(5,2,'Maria Vendedora','maria.v@zimbra.com',
    SHA2('Vendedor2026!',256),'+57-3000000005'),
(6,1,'Admin Soporte','admin2@zimbra.com',
    SHA2('Admin2026!',256),'+57-3000000006'),
(7,3,'Ana Supervisora','ana.s@zimbra.com',
    SHA2('Super2026!',256),'+57-3000000007'),
(8,2,'Luis Vendedor','luis.v@zimbra.com',
    SHA2('Vendedor2026!',256),'+57-3000000008'),
(9,2,'Sofia Vendedora','sofia.v@zimbra.com',
    SHA2('Vendedor2026!',256),'+57-3000000009'),
(10,3,'Jorge Supervisor','jorge.s@zimbra.com',
    SHA2('Super2026!',256),'+57-3000000010');

-- MARKETING (30)
INSERT INTO Marketing (id_empresa, nombre, descripcion, presupuesto) VALUES
(1,'Apple Marketing','Campañas globales de iPhone y servicios',25000000),
(2,'Microsoft Marketing','Promoción de Azure, Office y Windows',30000000),
(3,'Google Ads Team','Campañas de Google Workspace y Ads',28000000),
(4,'Amazon Marketing','Campañas de Prime y AWS',35000000),
(5,'Meta Marketing','Campañas de Facebook, Instagram y Ads',27000000),
(6,'IBM Marketing','Promoción de soluciones empresariales',18000000),
(7,'Oracle Marketing','Promoción de Oracle Cloud',20000000),
(8,'Samsung Marketing','Promoción Galaxy y electrodomésticos',32000000),
(9,'Sony Marketing','Campañas de PlayStation',22000000),
(10,'Dell Marketing','Campañas corporativas y laptops',12000000),
(11,'HP Marketing','Campañas de impresión y computadores',11000000),
(12,'Lenovo Marketing','Campañas de ThinkPad y servidores',10000000),
(13,'Cisco Marketing','Promoción de redes y ciberseguridad',15000000),
(14,'Intel Marketing','Promoción de procesadores',17000000),
(15,'NVIDIA Marketing','Campañas de GPU',20000000),
(16,'Adobe Marketing','Campañas Creative Cloud',21000000),
(17,'Salesforce Marketing','Campañas de CRM',25000000),
(18,'SAP Marketing','Campañas de ERP',16000000),
(19,'Siemens Marketing','Campañas industriales',14000000),
(20,'LG Marketing','Campañas de electrodomésticos',19000000),
(21,'Xiaomi Marketing','Campañas móviles IoT',12000000),
(22,'Huawei Marketing','Campañas telecomunicaciones',23000000),
(23,'Tesla Marketing','Campañas vehículos eléctricos',26000000),
(24,'Netflix Marketing','Campañas de series',30000000),
(25,'Spotify Marketing','Campañas de streaming',9000000),
(26,'Uber Marketing','Campañas de movilidad',15000000),
(27,'Airbnb Marketing','Campañas de viajes',13000000),
(28,'PayPal Marketing','Campañas de pagos digitales',11000000),
(29,'Visa Marketing','Campañas de tarjetas',20000000),
(30,'Mastercard Marketing','Campañas de pagos globales',21000000);

-- CAMPAÑAS (30)
INSERT INTO Campania
    (id_marketing, id_usuario, nombre, fecha_inicio, fecha_fin, costo, estado)
VALUES
(1,2,'Apple iPhone Launch 2026','2026-01-10','2026-03-10',12000000,'finalizada'),
(2,2,'Microsoft Azure Growth Q1','2026-01-05','2026-03-30',15000000,'finalizada'),
(3,3,'Google Workspace Boost','2026-02-01','2026-04-15',10000000,'activa'),
(4,3,'Amazon Prime Day LATAM','2026-03-01','2026-07-15',20000000,'activa'),
(5,5,'Meta Ads Expansion','2026-01-20','2026-05-20',13000000,'activa'),
(6,5,'IBM Hybrid Cloud Strategy','2026-02-10','2026-06-30',7000000,'activa'),
(7,8,'Oracle Cloud Enterprise','2026-02-05','2026-05-25',9000000,'activa'),
(8,8,'Samsung Galaxy S Launch','2026-01-15','2026-04-30',18000000,'finalizada'),
(9,9,'Sony PlayStation Holiday','2026-04-01','2026-12-20',16000000,'activa'),
(10,9,'Dell Business Laptops','2026-02-15','2026-06-15',5000000,'activa'),
(11,2,'HP Printer Solutions 2026','2026-01-25','2026-05-25',4500000,'activa'),
(12,3,'Lenovo ThinkPad Corporate','2026-03-01','2026-08-01',4800000,'activa'),
(13,5,'Cisco Secure Networking','2026-02-20','2026-07-20',6000000,'activa'),
(14,8,'Intel Core Ultra Promo','2026-01-05','2026-04-05',7500000,'finalizada'),
(15,9,'NVIDIA AI Data Center','2026-02-01','2026-09-01',14000000,'activa'),
(16,2,'Adobe Creative Students','2026-01-15','2026-06-15',8500000,'activa'),
(17,3,'Salesforce CRM Growth','2026-03-01','2026-09-30',11000000,'activa'),
(18,5,'SAP ERP Digital Transform','2026-02-10','2026-07-10',9000000,'activa'),
(19,8,'Siemens Industry 4.0','2026-03-01','2026-10-01',8000000,'activa'),
(20,9,'LG OLED TV Campaign','2026-01-20','2026-06-20',7000000,'activa'),
(21,2,'Xiaomi Smart Devices LATAM','2026-02-05','2026-07-05',6500000,'activa'),
(22,3,'Huawei 5G Infrastructure','2026-01-15','2026-09-15',15000000,'activa'),
(23,5,'Tesla EV Expansion','2026-03-01','2026-12-01',20000000,'activa'),
(24,8,'Netflix New Originals 2026','2026-01-01','2026-12-31',25000000,'activa'),
(25,9,'Spotify Premium Promo','2026-02-01','2026-06-30',4000000,'activa'),
(26,2,'Uber Eats Growth Colombia','2026-01-10','2026-05-10',5500000,'activa'),
(27,3,'Airbnb Summer Travel','2026-03-15','2026-09-15',6000000,'activa'),
(28,5,'PayPal Digital LATAM','2026-02-20','2026-08-20',5000000,'activa'),
(29,8,'Visa Secure Payments','2026-01-05','2026-06-05',12000000,'activa'),
(30,9,'Mastercard Contactless 2026','2026-01-12','2026-07-12',12500000,'activa');

-- LEADS (30: uno por campaña, vendedor rotado)

INSERT INTO `Lead`

    (id_campania, id_usuario, nombre, empresa, correo,
     telefono, pais, estado_contacto)
VALUES
(1,2,'Juan Perez','Tech Co','juan.perez@mail.com','+57-3101111111','Colombia','convertido'),
(2,2,'Maria Gomez','Soft SA','maria.gomez@mail.com','+57-3101111112','Colombia','convertido'),
(3,3,'Carlos Rodriguez','Data Corp','carlos.r@mail.com','+57-3101111113','Colombia','propuesta_enviada'),
(4,3,'Ana Martinez','Cloud Ltd','ana.m@mail.com','+57-3101111114','Colombia','en_seguimiento'),
(5,5,'Luis Hernandez','Net SAS','luis.h@mail.com','+57-3101111115','Colombia','prospecto'),
(6,5,'Sofia Lopez','Dev Inc','sofia.l@mail.com','+57-3101111116','Colombia','en_seguimiento'),
(7,8,'Andres Ramirez','ERP Co','andres.r@mail.com','+57-3101111117','Colombia','propuesta_enviada'),
(8,8,'Valentina Torres','Apps SA','valentina.t@mail.com','+57-3101111118','Colombia','convertido'),
(9,9,'Camilo Diaz','Games Ltd','camilo.d@mail.com','+57-3101111119','Colombia','en_seguimiento'),
(10,9,'Laura Castro','HW Corp','laura.c@mail.com','+57-3101111120','Colombia','prospecto'),
(11,2,'Mateo Vargas','Print SA','mateo.v@mail.com','+57-3101111121','Colombia','en_seguimiento'),
(12,3,'Juliana Rojas','Lap Inc','juliana.r@mail.com','+57-3101111122','Colombia','prospecto'),
(13,5,'Felipe Suarez','Net Co','felipe.s@mail.com','+57-3101111123','Colombia','en_seguimiento'),
(14,8,'Daniela Mendoza','Chip SA','daniela.m@mail.com','+57-3101111124','Colombia','perdido'),
(15,9,'Sebastian Moreno','GPU Ltd','sebastian.m@mail.com','+57-3101111125','Colombia','propuesta_enviada'),
(16,2,'Paula Navarro','Design Co','paula.n@mail.com','+57-3101111126','Colombia','en_seguimiento'),
(17,3,'David Jimenez','CRM SA','david.j@mail.com','+57-3101111127','Colombia','convertido'),
(18,5,'Natalia Ruiz','ERP Inc','natalia.r@mail.com','+57-3101111128','Colombia','propuesta_enviada'),
(19,8,'Alejandro Ortiz','Auto Corp','alejandro.o@mail.com','+57-3101111129','Colombia','en_seguimiento'),
(20,9,'Isabella Sanchez','TV SA','isabella.s@mail.com','+57-3101111130','Colombia','prospecto'),
(21,2,'Santiago Reyes','IoT Co','santiago.r@mail.com','+57-3101111131','Colombia','en_seguimiento'),
(22,3,'Manuela Acosta','Tel Inc','manuela.a@mail.com','+57-3101111132','Colombia','prospecto'),
(23,5,'Juan Mora','EV Ltd','juan.m@mail.com','+57-3101111133','Colombia','en_seguimiento'),
(24,8,'Sara Pineda','Stream SA','sara.p@mail.com','+57-3101111134','Colombia','perdido'),
(25,9,'Diego Aguilar','Music Co','diego.a@mail.com','+57-3101111135','Colombia','prospecto'),
(26,2,'Karen Bautista','Ride Inc','karen.b@mail.com','+57-3101111136','Colombia','en_seguimiento'),
(27,3,'Esteban Salazar','Host Ltd','esteban.s@mail.com','+57-3101111137','Colombia','prospecto'),
(28,5,'Viviana Guerrero','Pay SA','viviana.g@mail.com','+57-3101111138','Colombia','en_seguimiento'),
(29,8,'Miguel Pardo','Card Co','miguel.p@mail.com','+57-3101111139','Colombia','propuesta_enviada'),
(30,9,'Tatiana Cortes','Fin Inc','tatiana.c@mail.com','+57-3101111140','Colombia','prospecto');

-- SEGUIMIENTOS (10: para leads en seguimiento activo)
INSERT INTO Seguimiento
    (id_lead, id_usuario, canal, resultado, proxima_accion, notas)
VALUES
(4,3,'llamada','Interesado, pide demo','2026-05-25',
    'Cliente interesado en plan empresarial'),
(6,5,'correo','Respondió, quiere propuesta','2026-05-22',
    'Enviar propuesta esta semana'),
(9,9,'reunion','Reunión positiva','2026-05-28',
    'Mostramos producto, buen feedback'),
(11,2,'demo','Demo exitosa','2026-05-20',
    'Le gustó el módulo de reportes'),
(13,5,'llamada','Sin respuesta','2026-05-23',
    'Intentar de nuevo la próxima semana'),
(16,2,'correo','Abrió el correo, no respondió','2026-05-21',
    'Hacer seguimiento por teléfono'),
(19,8,'llamada','Interesado en precio','2026-05-26',
    'Enviar cotización detallada'),
(21,2,'reunion','Reunión pendiente de confirmar','2026-05-24',
    'Confirmar asistencia por WhatsApp'),
(23,5,'demo','Demo agendada','2026-05-27',
    'Preparar demo del módulo IoT'),
(28,5,'correo','Respondió con preguntas técnicas','2026-05-22',
    'Escalar a soporte técnico para responder');

-- PROVEEDORES (30)
INSERT INTO Proveedor
    (id_empresa, nombre, nit, telefono, correo, direccion)
VALUES
(2,'Microsoft Supplier Network','800200001','+1-425-500-0001','supplier@microsoft.com','Redmond, WA'),
(1,'Apple Supplier Program','800200002','+1-408-500-0002','supplier@apple.com','Cupertino, CA'),
(3,'Google Cloud Partner','800200003','+1-650-500-0003','supplier@google.com','Mountain View, CA'),
(7,'Oracle Hardware Supplier','800200004','+1-737-500-0004','supplier@oracle.com','Austin, TX'),
(6,'IBM Global Services','800200005','+1-914-500-0005','supplier@ibm.com','Armonk, NY'),
(13,'Cisco Network Supplier','800200006','+1-408-500-0006','supplier@cisco.com','San Jose, CA'),
(14,'Intel Technology Supplier','800200007','+1-408-500-0007','supplier@intel.com','Santa Clara, CA'),
(15,'NVIDIA Data Center','800200008','+1-408-500-0008','supplier@nvidia.com','Santa Clara, CA'),
(10,'Dell Enterprise Supplier','800200009','+1-512-500-0009','supplier@dell.com','Round Rock, TX'),
(11,'HP Supply Chain','800200010','+1-650-500-0010','supplier@hp.com','Palo Alto, CA'),
(12,'Lenovo Partner Supplier','800200011','+1-855-500-0011','supplier@lenovo.com','Morrisville, NC'),
(8,'Samsung Supplier Hub','800200012','+82-2-500-0012','supplier@samsung.com','Seoul'),
(9,'Sony Components','800200013','+81-3-500-0013','supplier@sony.com','Tokyo'),
(16,'Adobe Software Supplier','800200014','+1-408-500-0014','supplier@adobe.com','San Jose, CA'),
(17,'Salesforce Cloud Supplier','800200015','+1-415-500-0015','supplier@salesforce.com','San Francisco, CA'),
(18,'SAP Business Supplier','800200016','+49-6227-500-0016','supplier@sap.com','Walldorf'),
(19,'Siemens Industrial','800200017','+49-89-500-0017','supplier@siemens.com','Munich'),
(20,'LG Electronics Supplier','800200018','+82-2-500-0018','supplier@lg.com','Seoul'),
(21,'Xiaomi Global Supplier','800200019','+86-10-500-0019','supplier@xiaomi.com','Beijing'),
(22,'Huawei Telecom Supplier','800200020','+86-755-500-0020','supplier@huawei.com','Shenzhen'),
(4,'Amazon AWS Supplier','800200021','+1-206-500-0021','supplier@amazon.com','Seattle, WA'),
(5,'Meta Ads Supplier','800200022','+1-650-500-0022','supplier@meta.com','Menlo Park, CA'),
(23,'Tesla Parts Supplier','800200023','+1-650-500-0023','supplier@tesla.com','Palo Alto, CA'),
(24,'Netflix Media Supplier','800200024','+1-408-500-0024','supplier@netflix.com','Los Gatos, CA'),
(25,'Spotify Audio Supplier','800200025','+46-8-500-0025','supplier@spotify.com','Stockholm'),
(26,'Uber Fleet Supplier','800200026','+1-415-500-0026','supplier@uber.com','San Francisco, CA'),
(27,'Airbnb Hosting Supplier','800200027','+1-415-500-0027','supplier@airbnb.com','San Francisco, CA'),
(28,'PayPal Payments Supplier','800200028','+1-408-500-0028','supplier@paypal.com','San Jose, CA'),
(29,'Visa Banking Supplier','800200029','+1-650-500-0029','supplier@visa.com','Foster City, CA'),
(30,'Mastercard Payment Supplier','800200030','+1-914-500-0030','supplier@mastercard.com','Purchase, NY');

-- PRODUCTOS_SERVICIOS (30)
INSERT INTO Producto_Servicio
    (id_proveedor, nombre, descripcion, precio_base, stock)
VALUES
(1,'Microsoft 365 Business Standard','Licencia anual por usuario',480000,500),
(2,'Apple MacBook Pro 14','Laptop para empresas',8500000,50),
(3,'Google Workspace Business Plus','Suite empresarial anual',520000,400),
(4,'Oracle Database Enterprise','Licencia corporativa anual',12000000,80),
(5,'IBM Cloud Pak','Solución de nube híbrida',15000000,60),
(6,'Cisco Meraki MX','Firewall y seguridad empresarial',7500000,40),
(7,'Intel Xeon Processor','Procesador para servidores',6200000,100),
(8,'NVIDIA A100 GPU','GPU para inteligencia artificial',45000000,10),
(9,'Dell PowerEdge Server','Servidor empresarial',18000000,25),
(10,'HP LaserJet Pro','Impresora empresarial',1800000,70),
(11,'Lenovo ThinkPad X1 Carbon','Laptop corporativa',7200000,35),
(12,'Samsung Galaxy S26','Smartphone empresarial',5200000,90),
(13,'Sony PlayStation 6','Consola de videojuegos',3500000,120),
(14,'Adobe Creative Cloud','Licencia anual',2800000,200),
(15,'Salesforce CRM License','Licencia anual por usuario',3500000,300),
(16,'SAP S/4HANA License','ERP corporativo',25000000,50),
(17,'Siemens Automation Kit','Automatización industrial',30000000,20),
(18,'LG OLED 65 TV','Televisor corporativo premium',9000000,15),
(19,'Xiaomi Smart Camera','Cámara IoT inteligente',250000,500),
(20,'Huawei Router 5G','Router corporativo',1200000,100),
(21,'AWS EC2 Credits','Créditos de nube AWS',10000000,999),
(22,'Meta Business Ads Credits','Créditos para anuncios',5000000,999),
(23,'Tesla Wall Connector','Cargador vehículo eléctrico',2500000,30),
(24,'Netflix Business Subscription','Suscripción corporativa anual',850000,300),
(25,'Spotify Business Premium','Suscripción anual',420000,400),
(26,'Uber Eats Corporate','Paquete corporativo de almuerzos',600000,200),
(27,'Airbnb Business Credits','Créditos hospedaje corporativo',1500000,100),
(28,'PayPal Business API Plan','Plan de pagos digitales',1200000,500),
(29,'Visa Corporate Card Program','Programa tarjetas corporativas',1,999),
(30,'Mastercard Secure Payment','Servicio de pagos seguros',1,999);

-- PROPUESTAS
INSERT INTO Propuesta
    (id_lead, id_usuario, fecha_vigencia, valor_total, estado)
VALUES
(1,2,'2026-06-01',4800000,'aceptada'),
(2,2,'2026-06-05',17000000,'aceptada'),
(3,3,'2026-06-10',7800000,'enviada'),
(7,8,'2026-06-15',7500000,'enviada'),
(8,8,'2026-06-01',41600000,'aceptada'),
(15,9,'2026-06-20',45000000,'enviada'),
(17,3,'2026-06-08',3500000,'aceptada'),
(18,5,'2026-06-12',25000000,'enviada'),
(29,8,'2026-06-18',1200000,'enviada');

-- DETALLE_PROPUESTA
INSERT INTO Detalle_Propuesta
    (id_propuesta, id_producto, cantidad, precio_unitario, descuento)
VALUES
(1,1,10,480000,0),
(2,2,2,8500000,0),
(3,3,15,520000,5),
(4,6,3,7500000,10),
(5,12,8,5200000,0),
(6,8,1,45000000,0),
(7,15,1,3500000,0),
(8,16,1,25000000,5),
(9,28,15,1200000,10);

-- CLIENTES
INSERT INTO Cliente
    (id_empresa, id_lead, nombre, apellido, documento, telefono, correo)
VALUES
(2,1,'Juan','Perez','CC1000001','+57-3101111111','juan.perez@mail.com'),
(2,2,'Maria','Gomez','CC1000002','+57-3101111112','maria.gomez@mail.com'),
(8,8,'Valentina','Torres','CC1000008','+57-3101111118','valentina.torres@mail.com'),
(17,17,'David','Jimenez','CC1000017','+57-3101111127','david.jimenez@mail.com');

-- CLIENTE_CAMPANIA
INSERT INTO Cliente_Campania
    (id_cliente, id_campania, fecha_contacto, estado)
VALUES
(1,2,'2026-02-10','Convertido'),
(2,3,'2026-02-11','Convertido'),
(3,8,'2026-02-16','Convertido'),
(4,17,'2026-03-01','Convertido');

-- EMPLEADOS
INSERT INTO Empleado
    (id_usuario, id_empresa, nombre, cargo, telefono, correo)
VALUES
(2,2,'Carlos Vendedor','Ejecutivo de Ventas','+57-3000000002','carlos.v@zimbra.com'),
(3,3,'Laura Vendedora','Ejecutivo de Ventas','+57-3000000003','laura.v@zimbra.com'),
(5,5,'Maria Vendedora','Ejecutivo de Ventas','+57-3000000005','maria.v@zimbra.com'),
(8,8,'Luis Vendedor','Ejecutivo de Ventas','+57-3000000008','luis.v@zimbra.com'),
(9,9,'Sofia Vendedora','Ejecutivo de Ventas','+57-3000000009','sofia.v@zimbra.com');

-- PEDIDOS
INSERT INTO Pedido
    (id_cliente, id_empleado, id_propuesta, fecha, estado)
VALUES
(1,1,1,'2026-04-01','Entregado'),
(2,2,2,'2026-04-02','Entregado'),
(3,4,5,'2026-04-08','Entregado'),
(4,3,7,'2026-04-15','Entregado');

-- DETALLE_PEDIDO
INSERT INTO Detalle_Pedido
    (id_pedido, id_producto, cantidad, precio_unitario)
VALUES
(1,1,10,480000),
(2,2,2,8500000),
(3,12,8,5200000),
(4,15,1,3500000);

-- FACTURAS
INSERT INTO Factura (id_pedido, fecha_emision, total, estado) VALUES
(1,'2026-04-01',4800000,'pagada'),
(2,'2026-04-02',17000000,'pagada'),
(3,'2026-04-08',41600000,'pagada'),
(4,'2026-04-15',3500000,'pagada');

-- PAGOS
INSERT INTO Pago (id_factura, fecha_pago, metodo_pago, valor) VALUES
(1,'2026-04-02','Transferencia',4800000),
(2,'2026-04-03','Tarjeta',17000000),
(3,'2026-04-09','Transferencia',41600000),
(4,'2026-04-16','Transferencia',3500000);

-- TRANSACCIONES

-- TRANSACCIÓN 1: Ciclo completo CRM → ERP
START TRANSACTION;

UPDATE `Lead`

SET estado_contacto = 'convertido'
WHERE id_lead = 3;
INSERT INTO Cliente (id_empresa, id_lead, nombre, apellido, documento, telefono, correo)
	VALUES (3, 3, 'Carlos', 'Rodriguez', 'CC1000003', '+57-3101111113', 'carlos.r@mail.com');
SET @id_cliente_nuevo = LAST_INSERT_ID();
INSERT INTO Pedido (id_cliente, id_empleado, id_propuesta, fecha, estado)
	VALUES (@id_cliente_nuevo, 2, 3, '2026-05-15', 'Pendiente');
SET @id_pedido_nuevo = LAST_INSERT_ID();
INSERT INTO Detalle_Pedido (id_pedido, id_producto, cantidad, precio_unitario)
	VALUES (@id_pedido_nuevo, 3, 15, 520000);
INSERT INTO Factura (id_pedido, fecha_emision, total, estado)
	VALUES (@id_pedido_nuevo, '2026-05-15', 7800000, 'pendiente');
SET @id_factura_nueva = LAST_INSERT_ID();
INSERT INTO Pago (id_factura, fecha_pago, metodo_pago, valor)
	VALUES (@id_factura_nueva, '2026-05-15', 'Transferencia', 7800000);
UPDATE Pedido
SET estado = 'Entregado'
WHERE id_pedido = @id_pedido_nuevo;
COMMIT;

-- TRANSACCIÓN 2: Error por CHECK (cantidad = 0)
START TRANSACTION;
INSERT INTO Pedido (id_cliente, id_empleado, id_propuesta, fecha, estado)
	VALUES (1, 1, NULL, '2026-05-16', 'Pendiente');
SET @id_pedido2 = LAST_INSERT_ID();
-- Viola CHECK cantidad > 0
INSERT INTO Detalle_Pedido (id_pedido, id_producto, cantidad, precio_unitario)
	VALUES (@id_pedido2, 2, 0, 8500000);
ROLLBACK;

-- TRANSACCIÓN 3: Error por FK inexistente en Pago
START TRANSACTION;
INSERT INTO Pedido (id_cliente, id_empleado, id_propuesta, fecha, estado)
	VALUES (2, 2, NULL, '2026-05-17', 'Pendiente');
SET @id_pedido3 = LAST_INSERT_ID();
INSERT INTO Detalle_Pedido (id_pedido, id_producto, cantidad, precio_unitario)
	VALUES (@id_pedido3, 3, 5, 520000);
INSERT INTO Factura (id_pedido, fecha_emision, total, estado)
	VALUES (@id_pedido3, '2026-05-17', 2600000, 'pendiente');
-- Viola FK: id_factura 9999 no existe
INSERT INTO Pago (id_factura, fecha_pago, metodo_pago, valor)
	VALUES (9999, '2026-05-17', 'Tarjeta', 2600000);
ROLLBACK;

-- TRIGGER 1: Descontar stock al insertar Detalle_Pedido
DELIMITER $$
CREATE TRIGGER trg_DescontarStock
BEFORE INSERT ON Detalle_Pedido
FOR EACH ROW
BEGIN
    DECLARE stock_actual INT;
    SELECT stock
    INTO stock_actual
    FROM Producto_Servicio
    WHERE id_producto = NEW.id_producto;
    IF stock_actual < NEW.cantidad THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Stock insuficiente para el producto';
    ELSE
        UPDATE Producto_Servicio
        SET stock = stock - NEW.cantidad
        WHERE id_producto = NEW.id_producto;
    END IF;
END$$
DELIMITER ;

-- TRIGGER 2: Actualizar estado del Leadcuando una propuesta es aceptada
DELIMITER $$
CREATE TRIGGER trg_PropuestaAceptada
AFTER UPDATE ON Propuesta
FOR EACH ROW
BEGIN
    IF NEW.estado = 'aceptada'
       AND OLD.estado <> 'aceptada' THEN

        UPDATE `Lead`

        SET estado_contacto = 'propuesta_enviada'
        WHERE id_lead = NEW.id_lead;
    END IF;
END$$
DELIMITER ;

-- TRIGGER 3: Marcar factura como pagada cuando el pedido se entrega y tiene pago
DELIMITER $$
CREATE TRIGGER trg_PedidoEntregado
AFTER UPDATE ON Pedido
FOR EACH ROW
BEGIN
    IF NEW.estado = 'Entregado'
       AND OLD.estado <> 'Entregado' THEN
        UPDATE Factura
        SET estado = 'pagada'
        WHERE id_pedido = NEW.id_pedido
        AND EXISTS (SELECT 1 FROM Pago WHERE Pago.id_factura = Factura.id_factura);
    END IF;
END$$
DELIMITER ;

-- TRIGGER 4: Registrar auditoría cuando un pedido se entrega
DELIMITER $$
CREATE TRIGGER trg_AuditoriaVenta
AFTER UPDATE ON Pedido
FOR EACH ROW
BEGIN
    DECLARE usuario_empleado INT;
    IF NEW.estado = 'Entregado'
       AND OLD.estado <> 'Entregado' THEN
        SELECT id_usuario
        INTO usuario_empleado
        FROM Empleado
        WHERE id_empleado = NEW.id_empleado;
        IF usuario_empleado IS NOT NULL THEN
            INSERT INTO Auditoria ( id_usuario, accion, tabla_afectada, descripcion, fecha )
            VALUES
            ( usuario_empleado, 'VENTA_CERRADA', 'Pedido',
            CONCAT( 'Pedido ', NEW.id_pedido, ' marcado como Entregado en fecha ', NOW() ), NOW());
        END IF;

    END IF;
END$$
DELIMITER ;