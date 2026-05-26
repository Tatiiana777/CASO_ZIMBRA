function LeadForm({
  formulario,
  handleChange,
  handleSubmit,
  editando,
  cancelarEdicion,
}) {
  return (
    <form onSubmit={handleSubmit} className="formulario">
      <h2>{editando ? "Editar lead" : "Registrar lead"}</h2>

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
        required
      />

      <input
        type="email"
        name="correo"
        placeholder="Correo"
        value={formulario.correo}
        onChange={handleChange}
        required
      />

      <input
        type="text"
        name="telefono"
        placeholder="Telefono"
        value={formulario.telefono}
        onChange={handleChange}
      />

      <input
        type="text"
        name="pais"
        placeholder="Pais"
        value={formulario.pais}
        onChange={handleChange}
      />

      <select
        name="estado_contacto"
        value={formulario.estado_contacto}
        onChange={handleChange}
      >
        <option value="prospecto">Prospecto</option>
        <option value="en_seguimiento">En seguimiento</option>
        <option value="propuesta_enviada">Propuesta enviada</option>
        <option value="convertido">Convertido</option>
        <option value="perdido">Perdido</option>
      </select>

      <div className="form-grid">
        <label>
          Campania
          <input
            type="number"
            name="id_campania"
            min="1"
            value={formulario.id_campania}
            onChange={handleChange}
            required
          />
        </label>

        <label>
          Usuario
          <input
            type="number"
            name="id_usuario"
            min="1"
            value={formulario.id_usuario}
            onChange={handleChange}
            required
          />
        </label>
      </div>

      <button type="submit">{editando ? "Actualizar" : "Registrar"}</button>

      {editando && (
        <button type="button" className="btn-secundario" onClick={cancelarEdicion}>
          Cancelar edicion
        </button>
      )}
    </form>
  );
}

export default LeadForm;
