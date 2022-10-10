import React from "react";
import { useEffect, useState } from "react";
import "./CartItem.css";
import { useHistory } from "react-router-dom";
import axios from "axios";

//TODO smooth out hover animation using css

function CartItem({
  stateChanger,
  title,
  keyy,
  imageurl,
  game_id,
  arbTourney,
  setArbtourney,
  tournament_id,
  item_id,
  user_id,
}) {
  useEffect(() => {
    window.scroll(0, 0);
  }, []);

  function removeFromCart() {
    console.log(document.getElementById("prodTitle").textContent);
    console.log(user_id);
    console.log(item_id);
    const data = {
      userID: user_id,
      itemID: item_id,
      typeTemplate: "false",
      typeCart: "true",
      typePublic: "false",
    };
    axios
      .post("https://k3mt-backend.herokuapp.com//src/RemoveItemFromList.php", {
        data: data,
      })
      .then((result) => {
        console.log(result.data);
        stateChanger(100 * game_id);
      });
  }

  return (
    <div className="cartgameTile">
      <h3 id="prodTitle" className="Title">
        {title}
      </h3>
      <h3 className="Title">Price: R{game_id}</h3>
      <h3 className="Title">Quantity: {keyy}</h3>
      <button className="addButton" onClick={removeFromCart}>
        Remove Item
      </button>
    </div>
  );
}
export default CartItem;
