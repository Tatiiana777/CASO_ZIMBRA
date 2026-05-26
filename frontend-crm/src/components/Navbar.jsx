function Navbar({ usuario, logout }) {

  return (

    <nav className="navbar">

      <div className="logo">
        CRM Zimbra
      </div>

      <div className="navbar-user">

        <span>
          {usuario.nombre}
        </span>

        <span className="rol">
          {usuario.rol}
        </span>

        <button onClick={logout}>
          Salir
        </button>

      </div>

    </nav>

  );
}

export default Navbar;