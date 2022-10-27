import React from "react";
import { useEffect, useState } from "react";
import "./TemplateItem.css";
import { RiMoneyDollarBoxFill } from "react-icons/ri";
import { useHistory } from "react-router-dom";
import { MdRemoveShoppingCart } from "react-icons/md";
import axios from "axios";

//TODO smooth out hover animation using css

function TemplateItem({
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

  function removeFromTemplate() {
    const data = {
      userID: user_id,
      itemID: item_id,
    };
    axios
      .post(
        "https://k3mt-backend.herokuapp.com//src/RemoveItemFromTemplate.php",
        {
          data: data,
        }
      )
      .then((result) => {
        stateChanger(100 * game_id);
      });
  }

  return (
    <div className="templategameTile">
      <h3 id="templateItemTitle" className="templateItemTitle">
        {title}
      </h3>
      <div className="templatePriceSection">
        <RiMoneyDollarBoxFill className="templatePriceIconButton" />
        <h3 className="templateItemPrice">R{game_id}</h3>
        <MdRemoveShoppingCart
          className="templateRemoveIcon"
          onClick={removeFromTemplate}
        />
      </div>
      <div
        className="templateimageholder"
        style={{
          width: "90%",
          height: "90%",
          marginTop: "5%",
          backgroundSize: "100% 100%",
          borderRadius: "1.5em",
          marginLeft: "5%",
          backgroundImage: `url(${imageurl})`,
        }}
      ></div>
    </div>
  );
}
export default TemplateItem;
