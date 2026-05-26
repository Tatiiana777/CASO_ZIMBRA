function Sidebar({ vista, setVista, opciones }) {
  return (
    <aside className="sidebar">
      <h2>Menu</h2>

      {opciones.map(({ id, label }) => (
        <button
          key={id}
          className={vista === id ? "active" : ""}
          onClick={() => setVista(id)}
        >
          {label}
        </button>
      ))}
    </aside>
  );
}

export default Sidebar;
