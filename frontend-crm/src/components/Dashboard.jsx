import { useEffect, useMemo, useState } from "react";
import {
  actualizarLead,
  crearLead,
  eliminarLeadApi,
  listarLeads,
  obtenerDashboard,
} from "../services/api";
import Hero from "./Hero";
import LeadForm from "./LeadForm";
import LeadList from "./LeadList";
import Navbar from "./Navbar";
import Sidebar from "./sidebar";
import Stats from "./Stats";

const leadsIniciales = [
  {
    id_lead: 1,
    nombre: "Ana Morales",
    empresa: "Grupo Andino",
    correo: "ana@grupoandino.com",
    telefono: "+57 300 123 4567",
    pais: "Colombia",
    estado_contacto: "prospecto",
    id_campania: 1,
    id_usuario: 2,
  },
  {
    id_lead: 2,
    nombre: "Carlos Rojas",
    empresa: "Rojas Consultores",
    correo: "carlos@rojas.co",
    telefono: "+57 315 555 2040",
    pais: "Colombia",
    estado_contacto: "en_seguimiento",
    id_campania: 2,
    id_usuario: 2,
  },
  {
    id_lead: 3,
    nombre: "Mariana Vega",
    empresa: "Vega Retail",
    correo: "mariana@vegaretail.com",
    telefono: "+52 55 2345 8890",
    pais: "Mexico",
    estado_contacto: "propuesta_enviada",
    id_campania: 3,
    id_usuario: 3,
  },
];

const formularioVacio = {
  nombre: "",
  empresa: "",
  correo: "",
  telefono: "",
  pais: "",
  estado_contacto: "prospecto",
  id_campania: 1,
  id_usuario: 2,
};

const campanasDemo = [
  {
    nombre: "Google Workspace Boost",
    estado: "activa",
    presupuesto: "$10.000.000",
    leads: 8,
  },
  {
    nombre: "Salesforce CRM Growth",
    estado: "activa",
    presupuesto: "$11.000.000",
    leads: 6,
  },
  {
    nombre: "Apple iPhone Launch 2026",
    estado: "finalizada",
    presupuesto: "$12.000.000",
    leads: 5,
  },
];

const ventasDemo = [
  {
    id_venta: 1,
    cliente: "Juan Perez",
    producto: "Microsoft 365 Business Standard",
    total: 4800000,
    estado: "Pagada",
  },
  {
    id_venta: 2,
    cliente: "Maria Gomez",
    producto: "Apple MacBook Pro 14",
    total: 17000000,
    estado: "Pagada",
  },
  {
    id_venta: 3,
    cliente: "Valentina Torres",
    producto: "Samsung Galaxy S26",
    total: 41600000,
    estado: "Pagada",
  },
];

const ventaVacia = {
  cliente: "",
  producto: "",
  total: "",
  estado: "Pendiente",
};

const reportesDemo = [
  ["Conversion general", "fn_tasa_conversion()", "Funcion SQL"],
  ["Reporte mensual", "sp_reporte_mensual('2026-05')", "Procedimiento"],
  ["Dashboard comercial", "vw_dashboard_comercial", "Vista"],
  ["Conversiones por campania", "vw_reporte_conversiones", "Vista"],
];

const opcionesPorRol = {
  Administrador: [
    { id: "dashboard", label: "Dashboard" },
    { id: "leads", label: "Leads" },
    { id: "campanas", label: "Campanas" },
    { id: "ventas", label: "Ventas" },
    { id: "reportes", label: "Reportes" },
  ],
  Ventas: [
    { id: "dashboard", label: "Dashboard" },
    { id: "leads", label: "Leads" },
    { id: "ventas", label: "Ventas" },
  ],
  Marketing: [
    { id: "dashboard", label: "Dashboard" },
    { id: "leads", label: "Leads" },
    { id: "campanas", label: "Campanas" },
    { id: "reportes", label: "Reportes" },
  ],
};

const permisosPorRol = {
  Administrador: {
    crearLeads: true,
    editarLeads: true,
    eliminarLeads: true,
  },
  Ventas: {
    crearLeads: true,
    editarLeads: true,
    eliminarLeads: false,
  },
  Marketing: {
    crearLeads: false,
    editarLeads: false,
    eliminarLeads: false,
  },
};

function normalizarLead(lead) {
  return {
    ...formularioVacio,
    ...lead,
    id_campania: Number(lead.id_campania || 1),
    id_usuario: Number(lead.id_usuario || 2),
  };
}

function ordenarLeadsRecientes(leads) {
  return [...leads].sort((a, b) => {
    const fechaA = a.fecha_registro ? new Date(a.fecha_registro).getTime() : 0;
    const fechaB = b.fecha_registro ? new Date(b.fecha_registro).getTime() : 0;

    if (fechaA !== fechaB) {
      return fechaB - fechaA;
    }

    return Number(b.id_lead || 0) - Number(a.id_lead || 0);
  });
}

function formatoMoneda(valor) {
  return Number(valor || 0).toLocaleString("es-CO", {
    style: "currency",
    currency: "COP",
    maximumFractionDigits: 0,
  });
}

function Dashboard({ usuario, logout }) {
  const [vista, setVista] = useState("dashboard");
  const [leads, setLeads] = useState(leadsIniciales);
  const [dashboard, setDashboard] = useState(null);
  const [ventas, setVentas] = useState(ventasDemo);
  const [ventaForm, setVentaForm] = useState(ventaVacia);
  const [formulario, setFormulario] = useState(formularioVacio);
  const [editando, setEditando] = useState(null);
  const [cargando, setCargando] = useState(false);
  const [modoApi, setModoApi] = useState(false);
  const [mensaje, setMensaje] = useState("Datos demo cargados. Conecta PHP/MySQL para usar la base real.");
  const opcionesMenu = opcionesPorRol[usuario.rol] || opcionesPorRol.Ventas;
  const permisos = permisosPorRol[usuario.rol] || permisosPorRol.Ventas;
  const vistaActual = opcionesMenu.some((opcion) => opcion.id === vista) ? vista : "dashboard";

  useEffect(() => {
    let activo = true;

    async function cargarDatos() {
      setCargando(true);

      try {
        const [leadsApi, dashboardApi] = await Promise.all([
          listarLeads(),
          obtenerDashboard().catch(() => null),
        ]);

        if (!activo) {
          return;
        }

        setLeads(leadsApi.map(normalizarLead));
        setDashboard(dashboardApi);
        setModoApi(true);
        setMensaje("Conectado al back-end y base de datos.");
      } catch {
        if (activo) {
          setModoApi(false);
          setMensaje("Modo demo activo: el API PHP/MySQL no respondio.");
        }
      } finally {
        if (activo) {
          setCargando(false);
        }
      }
    }

    cargarDatos();

    return () => {
      activo = false;
    };
  }, []);

  const metricas = useMemo(() => {
    if (dashboard) {
      return {
        total: Number(dashboard.total_leads || leads.length),
        seguimientos: Number(dashboard.leads_en_seguimiento || 0),
        calificados: Number(dashboard.leads_con_propuesta || 0),
        convertidos: Number(dashboard.leads_convertidos || 0),
      };
    }

    return {
      total: leads.length,
      seguimientos: leads.filter((lead) => lead.estado_contacto === "en_seguimiento").length,
      calificados: leads.filter((lead) => lead.estado_contacto === "propuesta_enviada").length,
      convertidos: leads.filter((lead) => lead.estado_contacto === "convertido").length,
    };
  }, [dashboard, leads]);

  const leadsOrdenados = useMemo(() => ordenarLeadsRecientes(leads), [leads]);
  const ventasPagadas = ventas.filter((venta) => venta.estado === "Pagada");
  const totalFacturado = ventasPagadas.reduce((total, venta) => total + Number(venta.total || 0), 0);

  const refrescarDashboard = async () => {
    const dashboardApi = await obtenerDashboard().catch(() => null);
    setDashboard(dashboardApi);
  };

  const handleChange = (e) => {
    const { name, value } = e.target;

    setFormulario((actual) => ({
      ...actual,
      [name]: name.startsWith("id_") ? Number(value) : value,
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    const datos = {
      ...formulario,
      nombre: formulario.nombre.trim(),
      empresa: formulario.empresa.trim(),
      correo: formulario.correo.trim(),
      telefono: formulario.telefono.trim(),
      pais: formulario.pais.trim(),
      id_campania: Number(formulario.id_campania || 1),
      id_usuario: Number(formulario.id_usuario || 2),
    };

    if (!datos.nombre || !datos.empresa || !datos.correo) {
      alert("Nombre, empresa y correo son obligatorios.");
      return;
    }

    if (!editando && !permisos.crearLeads) {
      alert("Tu rol no tiene permiso para crear leads.");
      return;
    }

    if (editando && !permisos.editarLeads) {
      alert("Tu rol no tiene permiso para editar leads.");
      return;
    }

    try {
      if (modoApi && editando) {
        await actualizarLead(editando, datos);
      }

      if (modoApi && !editando) {
        await crearLead(datos);
      }

      if (modoApi) {
        const leadsApi = await listarLeads();
        setLeads(leadsApi.map(normalizarLead));
        await refrescarDashboard();
      } else if (editando) {
        setLeads((actuales) =>
          actuales.map((lead) =>
            lead.id_lead === editando ? { ...lead, ...datos } : lead
          )
        );
      } else {
        setLeads((actuales) => [
          {
            ...datos,
            id_lead: Date.now(),
          },
          ...actuales,
        ]);
      }

      setFormulario(formularioVacio);
      setEditando(null);
      setVista("leads");
    } catch (error) {
      alert(error.message);
    }
  };

  const editarLead = (lead) => {
    if (!permisos.editarLeads) {
      alert("Tu rol no tiene permiso para editar leads.");
      return;
    }

    setFormulario(normalizarLead(lead));
    setEditando(lead.id_lead);
    setVista("leads");
  };

  const eliminarLead = async (idLead) => {
    if (!permisos.eliminarLeads) {
      alert("Tu rol no tiene permiso para eliminar leads.");
      return;
    }

    try {
      if (modoApi) {
        await eliminarLeadApi(idLead);
        await refrescarDashboard();
      }

      setLeads((actuales) => actuales.filter((lead) => lead.id_lead !== idLead));

      if (editando === idLead) {
        setFormulario(formularioVacio);
        setEditando(null);
      }
    } catch (error) {
      alert(error.message);
    }
  };

  const cancelarEdicion = () => {
    setFormulario(formularioVacio);
    setEditando(null);
  };

  const handleVentaChange = (e) => {
    const { name, value } = e.target;

    setVentaForm((actual) => ({
      ...actual,
      [name]: value,
    }));
  };

  const registrarVenta = (e) => {
    e.preventDefault();

    if (!ventaForm.cliente.trim() || !ventaForm.producto.trim() || !ventaForm.total) {
      alert("Cliente, producto y total son obligatorios.");
      return;
    }

    setVentas((actuales) => [
      {
        ...ventaForm,
        cliente: ventaForm.cliente.trim(),
        producto: ventaForm.producto.trim(),
        total: Number(ventaForm.total),
        id_venta: Date.now(),
      },
      ...actuales,
    ]);
    setVentaForm(ventaVacia);
  };

  const cambiarEstadoVenta = (idVenta, estado) => {
    setVentas((actuales) =>
      actuales.map((venta) =>
        venta.id_venta === idVenta ? { ...venta, estado } : venta
      )
    );
  };

  const eliminarVenta = (idVenta) => {
    setVentas((actuales) => actuales.filter((venta) => venta.id_venta !== idVenta));
  };

  const renderCampanas = () => (
    <section className="module-view">
      <div className="section-heading">
        <div>
          <p className="eyebrow">Marketing</p>
          <h2>Campanas activas</h2>
        </div>
        <span>{campanasDemo.length} campanas destacadas</span>
      </div>

      <div className="summary-grid">
        <div className="summary-card">
          <strong>30</strong>
          <span>Campanas en BD</span>
        </div>
        <div className="summary-card">
          <strong>{metricas.total}</strong>
          <span>Leads generados</span>
        </div>
        <div className="summary-card">
          <strong>{metricas.convertidos}</strong>
          <span>Conversiones</span>
        </div>
      </div>

      <div className="data-table">
        <div className="table-row table-head sales-row">
          <span>Campana</span>
          <span>Estado</span>
          <span>Presupuesto</span>
          <span>Leads</span>
        </div>
        {campanasDemo.map((campana) => (
          <div className="table-row" key={campana.nombre}>
            <span>{campana.nombre}</span>
            <span>{campana.estado}</span>
            <span>{campana.presupuesto}</span>
            <span>{campana.leads}</span>
          </div>
        ))}
      </div>
    </section>
  );

  const renderVentas = () => (
    <section className="module-view">
      <div className="section-heading">
        <div>
          <p className="eyebrow">ERP comercial</p>
          <h2>Ventas y facturacion</h2>
        </div>
        <span>Pedidos, facturas y pagos</span>
      </div>

      <div className="summary-grid">
        <div className="summary-card">
          <strong>{formatoMoneda(totalFacturado)}</strong>
          <span>Total facturado</span>
        </div>
        <div className="summary-card">
          <strong>{ventasPagadas.length}</strong>
          <span>Facturas pagadas</span>
        </div>
        <div className="summary-card">
          <strong>{metricas.convertidos}</strong>
          <span>Leads convertidos</span>
        </div>
      </div>

      <form className="inline-form" onSubmit={registrarVenta}>
        <input
          name="cliente"
          placeholder="Cliente"
          value={ventaForm.cliente}
          onChange={handleVentaChange}
        />
        <input
          name="producto"
          placeholder="Producto o servicio"
          value={ventaForm.producto}
          onChange={handleVentaChange}
        />
        <input
          name="total"
          type="number"
          min="1"
          placeholder="Total"
          value={ventaForm.total}
          onChange={handleVentaChange}
        />
        <select name="estado" value={ventaForm.estado} onChange={handleVentaChange}>
          <option>Pendiente</option>
          <option>Pagada</option>
          <option>Anulada</option>
        </select>
        <button type="submit">Registrar venta</button>
      </form>

      <div className="data-table">
        <div className="table-row table-head">
          <span>Cliente</span>
          <span>Producto</span>
          <span>Total</span>
          <span>Estado</span>
          <span>Acciones</span>
        </div>
        {ventas.map((venta) => (
          <div className="table-row sales-row" key={venta.id_venta}>
            <span>{venta.cliente}</span>
            <span>{venta.producto}</span>
            <span>{formatoMoneda(venta.total)}</span>
            <span>{venta.estado}</span>
            <span className="table-actions">
              {venta.estado !== "Pagada" && (
                <button type="button" onClick={() => cambiarEstadoVenta(venta.id_venta, "Pagada")}>
                  Pagar
                </button>
              )}
              {venta.estado !== "Anulada" && (
                <button
                  type="button"
                  className="btn-secundario"
                  onClick={() => cambiarEstadoVenta(venta.id_venta, "Anulada")}
                >
                  Anular
                </button>
              )}
              {permisos.eliminarLeads && (
                <button
                  type="button"
                  className="btn-eliminar"
                  onClick={() => eliminarVenta(venta.id_venta)}
                >
                  Eliminar
                </button>
              )}
            </span>
          </div>
        ))}
      </div>
    </section>
  );

  const renderReportes = () => (
    <section className="module-view">
      <div className="section-heading">
        <div>
          <p className="eyebrow">Analitica SQL</p>
          <h2>Reportes disponibles</h2>
        </div>
        <span>Vistas, funciones y procedimientos</span>
      </div>

      <div className="summary-grid">
        <div className="summary-card">
          <strong>3</strong>
          <span>Vistas SQL</span>
        </div>
        <div className="summary-card">
          <strong>2</strong>
          <span>Funciones</span>
        </div>
        <div className="summary-card">
          <strong>5</strong>
          <span>Procedimientos</span>
        </div>
      </div>

      <div className="data-table report-table">
        <div className="table-row table-head">
          <span>Reporte</span>
          <span>Objeto SQL</span>
          <span>Tipo</span>
        </div>
        {reportesDemo.map(([nombre, objeto, tipo]) => (
          <div className="table-row" key={objeto}>
            <span>{nombre}</span>
            <code>{objeto}</code>
            <span>{tipo}</span>
          </div>
        ))}
      </div>
    </section>
  );

  return (
    <div className="app-shell">
      <Navbar usuario={usuario} logout={logout} />

      <div className="workspace">
        <Sidebar vista={vista} setVista={setVista} opciones={opcionesMenu} />

        <main className="main-content">
          <div className={modoApi ? "status-bar ok" : "status-bar"}>
            <span>{cargando ? "Cargando datos..." : mensaje}</span>
          </div>

          {vistaActual === "dashboard" && (
            <>
              <Hero />
              <Stats
                total={metricas.total}
                seguimientos={metricas.seguimientos}
                calificados={metricas.calificados}
                convertidos={metricas.convertidos}
              />
              <section className="panel">
                <div>
                  <p className="eyebrow">Actividad reciente</p>
                  <h2>Leads mas nuevos</h2>
                </div>
                <LeadList
                  leads={leadsOrdenados.slice(0, 3)}
                  editarLead={editarLead}
                  eliminarLead={eliminarLead}
                  permisos={permisos}
                />
              </section>
            </>
          )}

          {vistaActual === "leads" && (
            <section className="leads-layout">
              {permisos.crearLeads || editando ? (
                <LeadForm
                  formulario={formulario}
                  handleChange={handleChange}
                  handleSubmit={handleSubmit}
                  editando={Boolean(editando)}
                  cancelarEdicion={cancelarEdicion}
                />
              ) : (
                <section className="permission-panel">
                  <p className="eyebrow">Solo consulta</p>
                  <h2>Leads disponibles</h2>
                  <p>Tu rol puede revisar leads y campanas, pero no crear ni modificar registros comerciales.</p>
                </section>
              )}
              <div className="panel">
                <div className="section-heading">
                  <div>
                    <p className="eyebrow">Base comercial</p>
                    <h2>Leads registrados</h2>
                  </div>
                  <span>{leads.length} registros</span>
                </div>
                <LeadList
                  leads={leadsOrdenados}
                  editarLead={editarLead}
                  eliminarLead={eliminarLead}
                  permisos={permisos}
                />
              </div>
            </section>
          )}

          {vistaActual === "campanas" && renderCampanas()}

          {vistaActual === "ventas" && renderVentas()}

          {vistaActual === "reportes" && renderReportes()}
        </main>
      </div>
    </div>
  );
}

export default Dashboard;
