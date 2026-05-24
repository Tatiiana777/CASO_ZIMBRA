import { useEffect, useState } from "react";
import "./App.css";

function App() {

  const [leads, setLeads] = useState([]);

  const [editando, setEditando] = useState(null);

  const [formulario, setFormulario] = useState({
    nombre: "",
    empresa: "",
    correo: "",
    telefono: "",
    pais: "",
    estado_contacto: "prospecto",
    id_campania: 1,
    id_usuario: 2,
  });

  const API = "http://localhost:8000/api.php?entidad=lead";

  // OBTENER LEADS
  const obtenerLeads = async () => {

    try {

      const respuesta = await fetch(API);

      const datos = await respuesta.json();

      setLeads(datos);

    } catch (error) {

      console.error(error);

    }
  };

  useEffect(() => {

    obtenerLeads();

  }, []);

  // ELIMINAR LEAD
  const eliminarLead = async (id) => {

    const confirmar = window.confirm(
      "¿Deseas eliminar este lead?"
    );

    if (!confirmar) return;

    try {

      await fetch(`${API}&id=${id}`, {
        method: "DELETE",
      });

      obtenerLeads();

      alert("Lead eliminado correctamente");

    } catch (error) {

      console.error(error);

    }
  };

  // EDITAR LEAD
  const editarLead = (lead) => {

    setFormulario({
      nombre: lead.nombre,
      empresa: lead.empresa,
      correo: lead.correo,
      telefono: lead.telefono,
      pais: lead.pais,
      estado_contacto: lead.estado_contacto,
      id_campania: lead.id_campania,
      id_usuario: lead.id_usuario,
    });

    

    setEditando(lead.id_lead);

    window.scrollTo({
      top:0,
      behavior: "smooth",

    });
    
    
  };

  // CAMBIOS EN INPUTS
  const handleChange = (e) => {

    setFormulario({
      ...formulario,
      [e.target.name]: e.target.value,
    });
  };

  // ENVIAR FORMULARIO
  const handleSubmit = async (e) => {

    e.preventDefault();

    try {

      await fetch(

        editando
          ? `${API}&id=${editando}`
          : API,

        {

          method: editando ? "PUT" : "POST",

          headers: {
            "Content-Type": "application/json",
          },

          body: JSON.stringify(

            editando

              ? {
                  id_lead: editando,
                  ...formulario,
                }

              : formulario

          ),

        }

      );

      obtenerLeads();

      alert(

        editando
        ?"Lead actualizado correctamente"
        :"lead registrado correctamente"
      );

      setEditando(null);

      setFormulario({
        nombre: "",
        empresa: "",
        correo: "",
        telefono: "",
        pais: "",
        estado_contacto: "prospecto",
        id_campania: 1,
        id_usuario: 2,
      });

    } catch (error) {

      console.error(error);

    }
  };

  return (

    <div className="contenedor">

      <h1>CRM Zimbra</h1>

      <form
        onSubmit={handleSubmit}
        className="formulario"
      >

        <input
          type="text"
          name="nombre"
          placeholder="Nombre"
          value={formulario.nombre}
          onChange={handleChange}
          required
        />

        <input
          type="text"
          name="empresa"
          placeholder="Empresa"
          value={formulario.empresa}
          onChange={handleChange}
        />

        <input
          type="email"
          name="correo"
          placeholder="Correo"
          value={formulario.correo}
          onChange={handleChange}
        />

        <input
          type="text"
          name="telefono"
          placeholder="Teléfono"
          value={formulario.telefono}
          onChange={handleChange}
        />

        <input
          type="text"
          name="pais"
          placeholder="País"
          value={formulario.pais}
          onChange={handleChange}
        />

        <button type="submit">

          {

            editando

              ? "Actualizar Lead"

              : "Registrar Lead"

          }

        </button>

      </form>

      <h2>Listado de Leads</h2>

      <div className="lista">

        {

          leads.map((lead) => (

            <div
              key={lead.id_lead}
              className="card"
            >

              <h3>{lead.nombre}</h3>

              <p>
                <strong>Empresa:</strong>
                {" "}
                {lead.empresa}
              </p>

              <p>
                <strong>Correo:</strong>
                {" "}
                {lead.correo}
              </p>

              <p>
                <strong>Estado:</strong>
                {" "}
                {lead.estado_contacto}
              </p>

              <button
                className="btn-editar"
                onClick={() => editarLead(lead)}
              >
                Editar
                
              </button>

              <button
                className="btn-eliminar"
                onClick={() => eliminarLead(lead.id_lead)}
              >
                Eliminar
              </button>

            </div>

          ))

        }

      </div>

    </div>

  );
}

export default App;