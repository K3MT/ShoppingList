import React, { useEffect, useState } from "react";
import "./Home.css";
import jdata from "./data.json";
import Tile from "./Tile.js";
import { useNavigate } from "react-router-dom";
export default function Home(props) {
  console.log(jdata.data[0].itemID);
  var listArray = Array.from(jdata.data);
  console.log(listArray);

  const navigate = useNavigate();

  const homeToLogin = () => {
    navigate("/login");
  };

  const homeToRegister = () => {
    navigate("/register");
  };

  return (
    <div className="Auth-form-container-home">
      <span>
        <nav class="navMenu">
          <a href="#">Home</a>
          <a href="#" onClick={homeToLogin}>
            Login
          </a>
          <a href="#" onClick={homeToRegister}>
            Register
          </a>
        </nav>
      </span>

      <div className="shoppinglist">
        {listArray.map((item) => {
          return (
            <Tile
              title={item.itemName}
              key={item.itemID}
              imageurl={item.itemImageURL}
              game_id={item.itemPrice}
              tournament_id={item.itemMass}
              arbTourney={item.itemMass}
              setArbtourney={item.brandID}
            />
          );
        })}
      </div>

      <div className="homearea">
        <ul className="homecircles">
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
        </ul>
      </div>
    </div>
  );
}
