import React, { useEffect, useState } from "react";
import Tile from "./Tile.js";
import "./Home.css";
import "./style.css";
import jdata from "./data.json";
import { useNavigate } from "react-router-dom";
export default function Home(props) {
  console.log(jdata.data[0].itemID);
  var listArray = Array.from(jdata.data);
  console.log(listArray);

  //Initialize useNavigate for routing
  const navigate = useNavigate();

  //Navigate from home to login page
  const homeToLogin = () => {
    navigate("/login");
  };

  //Navigate to register from home
  const homeToRegister = () => {
    navigate("/register");
  };

  //Return the html
  return (
    <div className="Auth-form-container-home">
      <div className="homearea">
        <ul className="homecircles-home">
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
      <span>
        {/* <a href="#" class="logo">
          {" "}
          <i class="fas fa-shopping-basket"></i> K3MT{" "}
        </a> */}
        <nav class="navMenuHome">
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
        <section class="home" id="home">
          <div class="content">
            <h3>
              Fresh and <span>Affordable</span> products for you
            </h3>
          </div>
        </section>
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
    </div>
  );
}
