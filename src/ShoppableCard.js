import React from "react";
import { useEffect, useState } from "react";
import "./ShoppableCard.css";
import { useHistory } from "react-router-dom";
import axios from "axios";

//TODO smooth out hover animation using css

function ShoppableCard({
  title,
  keyy,
  imageurl,
  game_id,
  arbTourney,
  setArbtourney,
  tournament_id,
  user_id,
}) {
  useEffect(() => {
    window.scroll(0, 0);
  }, []);

  function addTocart() {
    console.log(document.getElementById("prodTitle").textContent);
    const data = {
      userID: keyy,
      itemID: user_id,
    };
    axios
      .post(
        "https://k3mt-shopping-list-backend.herokuapp.com/src/AddItemToCart.php",
        {
          data: data,
        }
      )
      .then((result) => {
        console.log(result.data);
      });
  }

  return (
    <div className="gameTile">
      <h3 id="prodTitle" className="Title">
        {title}
      </h3>
      <h3 className="Title">R{game_id}</h3>
      <div
        className="imageholder"
        style={{
          width: "20em",
          height: "15em",
          backgroundSize: "cover",
          borderRadius: "1em",
          backgroundImage: `url(${imageurl})`,
        }}
      ></div>
      <button className="addButton" onClick={addTocart}>
        Add
      </button>
    </div>
  );
}
export default ShoppableCard;
