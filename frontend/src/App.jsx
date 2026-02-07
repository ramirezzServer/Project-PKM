import { useEffect } from "react";
import api from "./api/axios";

function App() {
  const loginAndGetProfile = async () => {
    try {
      // 1️⃣ LOGIN
      const loginRes = await api.post("/auth/login", {
        email: "test@example.com",
        password: "password",
      });

      const token = loginRes.data.token;
      localStorage.setItem("token", token);

      console.log("LOGIN SUCCESS:", loginRes.data);

      // 2️⃣ LANGSUNG PANGGIL PROFILE (SETELAH TOKEN ADA)
      const profileRes = await api.get("/user/profile");
      console.log("PROFILE:", profileRes.data);

    } catch (err) {
      console.error(
        "AUTH FLOW ERROR:",
        err.response?.data || err
      );
    }
  };

  useEffect(() => {
    loginAndGetProfile();
  }, []);

  return (
    <div style={{ padding: "2rem" }}>
      <h1>Auth + Axios Interceptor</h1>
      <p>Check console for login & profile result.</p>
    </div>
  );
}

export default App;
