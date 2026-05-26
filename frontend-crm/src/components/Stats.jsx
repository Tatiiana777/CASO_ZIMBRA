function Stats({ total, seguimientos, calificados, convertidos }) {
  return (
    <section className="stats">
      <div className="stat-card">
        <h2>{total}</h2>
        <p>Total leads</p>
      </div>

      <div className="stat-card">
        <h2>{seguimientos}</h2>
        <p>Seguimientos</p>
      </div>

      <div className="stat-card">
        <h2>{calificados}</h2>
        <p>Con propuesta</p>
      </div>

      <div className="stat-card">
        <h2>{convertidos}</h2>
        <p>Convertidos</p>
      </div>
    </section>
  );
}

export default Stats;
