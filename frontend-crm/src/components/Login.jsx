import { useState } from "react";

function Login({ login }) {
  const [correo, setCorreo] = useState("");
  const [password, setPassword] = useState("");

  const handleSubmit = (e) => {
    e.preventDefault();
    login(correo, password);
  };

  return (
    <div className="login-container">
      <form className="login-form" onSubmit={handleSubmit}>
        <div className="brand-mark">Z</div>
        <h1>CRM Zimbra</h1>
        <p>Plataforma de gestion empresarial</p>

        <label>
          <span>Correo</span>
          <input
            type="email"
            placeholder="admin@zimbra.com"
            value={correo}
            onChange={(e) => setCorreo(e.target.value)}
            required
          />
        </label>

        <label>
          <span>Contrasena</span>
          <input
            type="password"
            placeholder="12345"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            required
          />
        </label>

        <button type="submit">Ingresar</button>

        <div className="demo-users">
          <h4>Usuarios demo</h4>
          <p>admin@zimbra.com / 12345</p>
          <p>ventas@zimbra.com / 12345</p>
          <p>marketing@zimbra.com / 12345</p>
        </div>
      </form>
    </div>
  );
}

export default Login;
