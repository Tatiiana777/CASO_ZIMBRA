const estados = {
  prospecto: "Prospecto",
  en_seguimiento: "En seguimiento",
  propuesta_enviada: "Propuesta enviada",
  convertido: "Convertido",
  perdido: "Perdido",
};

function LeadList({ leads, editarLead, eliminarLead, permisos }) {
  return (
    <div className="lista">
      {leads.length === 0 ? (
        <p className="empty-list">No hay leads registrados.</p>
      ) : (
        leads.map((lead) => (
          <div key={lead.id_lead} className="card">
            <div className="card-header">
              <h3>{lead.nombre}</h3>
              <span>{estados[lead.estado_contacto] || lead.estado_contacto}</span>
            </div>

            <p>
              <strong>Empresa:</strong> {lead.empresa}
            </p>
            <p>
              <strong>Correo:</strong> {lead.correo}
            </p>
            <p>
              <strong>Telefono:</strong> {lead.telefono || "Sin dato"}
            </p>
            <p>
              <strong>Pais:</strong> {lead.pais || "Sin dato"}
            </p>

            {(permisos?.editarLeads || permisos?.eliminarLeads) && (
              <div className="card-actions">
                {permisos?.editarLeads && (
                  <button className="btn-editar" onClick={() => editarLead(lead)}>
                    Editar
                  </button>
                )}
                {permisos?.eliminarLeads && (
                  <button
                    className="btn-eliminar"
                    onClick={() => eliminarLead(lead.id_lead)}
                  >
                    Eliminar
                  </button>
                )}
              </div>
            )}
          </div>
        ))
      )}
    </div>
  );
}

export default LeadList;
