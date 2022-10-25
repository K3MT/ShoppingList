import React from "react";
import { useEffect, useState } from "react";
import "./CartItem.css";
import { useHistory } from "react-router-dom";
import axios from "axios";
import { RiMoneyDollarBoxFill } from "react-icons/ri";
import { MdRemoveShoppingCart } from "react-icons/md";
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
        stateChanger(100 * game_id);
      });
  }

  return (
    <div className="cartgameTile">
      <h3 id="prodTitle" className="cartItemTitle">
        {title}
      </h3>
      <div className="priceSection">
        <RiMoneyDollarBoxFill className="priceIcon" />
        <h3 className="cartItemPrice">R{game_id}</h3>
        <h3 className="cartItemCount">{keyy}x</h3>
      </div>
      <div
        className="imageholder"
        style={{
          width: "90%",
          height: "200px",
          marginTop: "-1.75%",
          backgroundSize: "100% 100%",
          borderRadius: "1.5em",
          marginLeft: "5%",
          backgroundImage: `url(${imageurl})`,
        }}
      ></div>

      <MdRemoveShoppingCart className="RemoveIcon" onClick={removeFromCart} />
      {/* <button className="addButton" onClick={removeFromCart}>
        Remove Item
      </button> */}
    </div>
  );
}
export default CartItem;
