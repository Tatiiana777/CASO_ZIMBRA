import { useState } from "react";
import Dashboard from "./components/Dashboard";
import Login from "./components/Login";

function App() {
  const [usuario, setUsuario] = useState(null);

  const usuarios = [
    {
      correo: "admin@zimbra.com",
      password: "12345",
      rol: "Administrador",
      nombre: "Admin Zimbra",
    },
    {
      correo: "ventas@zimbra.com",
      password: "12345",
      rol: "Ventas",
      nombre: "Usuario Ventas",
    },
    {
      correo: "marketing@zimbra.com",
      password: "12345",
      rol: "Marketing",
      nombre: "Usuario Marketing",
    },
  ];

  const login = (correo, password) => {
    const encontrado = usuarios.find(
      (u) => u.correo === correo.trim() && u.password === password
    );

    if (encontrado) {
      setUsuario(encontrado);
    } else {
      alert("Credenciales incorrectas");
    }
  };

  const logout = () => {
    setUsuario(null);
  };

  return usuario ? (
    <Dashboard usuario={usuario} logout={logout} />
  ) : (
    <Login login={login} />
  );
}

export default App;
