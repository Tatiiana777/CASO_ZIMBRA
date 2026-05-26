const API_BASE_URL = import.meta.env.VITE_API_URL || "http://localhost/CASO_ZIMBRA/api.php";

async function request(url, options = {}) {
  const response = await fetch(url, {
    headers: {
      "Content-Type": "application/json",
      ...(options.headers || {}),
    },
    ...options,
  });

  if (!response.ok) {
    const error = await response.json().catch(() => ({}));
    throw new Error(error.mensaje || "Error de comunicacion con el API");
  }

  return response.json();
}

export function listarLeads() {
  return request(`${API_BASE_URL}?entidad=lead`);
}

export function crearLead(lead) {
  return request(`${API_BASE_URL}?entidad=lead`, {
    method: "POST",
    body: JSON.stringify(lead),
  });
}

export function actualizarLead(idLead, lead) {
  return request(`${API_BASE_URL}?entidad=lead&id=${idLead}`, {
    method: "PUT",
    body: JSON.stringify({
      ...lead,
      id_lead: idLead,
    }),
  });
}

export function eliminarLeadApi(idLead) {
  return request(`${API_BASE_URL}?entidad=lead&id=${idLead}`, {
    method: "DELETE",
  });
}

export function obtenerDashboard() {
  return request(`${API_BASE_URL}?accion=dashboard`);
}
