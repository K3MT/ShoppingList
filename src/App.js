import "bootstrap/dist/css/bootstrap.min.css";
import {
  BrowserRouter,
  Routes,
  Route,
  useNavigate,
  useLocation,
} from "react-router-dom";
import { useState, useEffect } from "react";
import Register from "./Register.js";
import Login from "./Login.js";
import Reset from "./Reset.js";
import TFA from "./TFA.js";
import Home from "./Home.js";
import Profile from "./Profile.js";
import EditProfile from "./EditProfile.js";
import Cart from "./Cart.js";
import ProfileManagement from "./ProfileManagement.js";
import UserListCreation from "./ListCreation.js";
import ListCreationInter from "./ListCreationInter.js";

function App() {
  return (
    <div>
      <Routes>
        <Route index path="/" element={<Home />} />
        <Route path="/register" element={<Register />} />
        <Route path="/login" element={<Login />} />
        <Route path="/reset" element={<Reset />} />
        <Route path="/tfa" element={<TFA />} />
        <Route path="/profile" element={<Profile />} />
        <Route path="/editprofile" element={<EditProfile />} />
        <Route path="/cart" element={<Cart />} />
        <Route path="/management" element={<ProfileManagement />} />
        <Route path="/userlistcreation" element={<UserListCreation />} />
        <Route path="/listcreationinter" element={<ListCreationInter />} />
      </Routes>
    </div>
  );
}
export default App;
