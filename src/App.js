import "bootstrap/dist/css/bootstrap.min.css"
import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom"
import Register from "./Register.js"
import Login from "./Login.js"
import Reset from "./Reset.js"
import TFA from "./TFA.js"
import Home from "./Home.js"

function App() {
  return (
    <BrowserRouter>
      
      <Routes>
        <Route path="/register" element={<Register />} />
        <Route path="/login" element={<Login />} />
        <Route path="/reset" element={<Reset />} />
        <Route path="/tfa" element={<TFA />} />
        <Route root path="/home" element={<Home />} />
      </Routes>
      <Home/>
    </BrowserRouter>
  )
}
export default App