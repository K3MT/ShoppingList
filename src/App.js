import "bootstrap/dist/css/bootstrap.min.css";
import { BrowserRouter, Routes, Route, useNavigate } from "react-router-dom";
import { useState, useEffect } from "react";
import Register from "./Register.js";
import Login from "./Login.js";
import Reset from "./Reset.js";
import TFA from "./TFA.js";
import Home from "./Home.js";
import Profile from "./Profile.js";
import EditProfile from "./EditProfile.js";
import Cart from "./Cart.js";

function App() {
  return (
    <div>
      <Routes>
        <Route path="/register" element={<Register />} />
        <Route path="/login" element={<Login />} />
        <Route path="/reset" element={<Reset />} />
        <Route path="/tfa" element={<TFA />} />
        <Route path="/home" element={<Home />} />
        <Route path="/profile" element={<Profile />} />
        <Route path="/editprofile" element={<EditProfile />} />
        <Route path="/cart" element={<Cart />} />
      </Routes>
    </div>
  );
}
export default App;
