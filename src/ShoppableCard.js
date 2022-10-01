import React from "react";
import { useEffect, useState } from "react";
import "./ShoppableCard.css";
import { useHistory } from "react-router-dom";
import axios from "axios";
import { BsInfoCircle } from "react-icons/bs";
import Popup from "reactjs-popup";
import "reactjs-popup/dist/index.css";

//TODO smooth out hover animation using css

function ShoppableCard({
  product_title,
  product_ID,
  product_imageurl,
  product_price,
  product_mass,
  product_brandID,
  product_description,
  user_id,
}) {
  useEffect(() => {
    window.scroll(0, 0);
  }, []);

  function addTocart() {
    console.log(document.getElementById("prodTitle").textContent);
    const data = {
      userID: user_id,
      itemID: product_ID,
      typeTemplate: "false",
      typeCart: "true",
      typePublic: "false",
    };
    axios
      .post("https://k3mt-backend.herokuapp.com//src/AddItemToList.php", {
        data: data,
      })
      .then((result) => {
        console.log(result.data);
      });
  }

  function addTotemplate() {
    console.log(document.getElementById("prodTitle").textContent);
    const data = {
      userID: user_id,
      itemID: product_ID,
      typeTemplate: "true",
      typeCart: "false",
      typePublic: "false",
    };
    axios
      .post("https://k3mt-backend.herokuapp.com//src/AddItemToList.php", {
        data: data,
      })
      .then((result) => {
        console.log(result.data);
      });
  }

  return (
    <div className="Tile">
      <h3 id="prodTitle" className="Title">
        {product_title}
      </h3>
      <h3 className="Title">R{product_price}</h3>
      <div
        className="imageholder"
        style={{
          width: "20em",
          height: "15em",
          backgroundSize: "cover",
          borderRadius: "1em",
          backgroundImage: `url(${product_imageurl})`,
        }}
      ></div>
      <button className="addProfileButton" onClick={addTocart}>
        Add to cart
      </button>
      <button className="templateProfileButton" onClick={addTotemplate}>
        Add to Template
      </button>
      <Popup
        className="PopupInfo"
        trigger={<BsInfoCircle className="InfoButton" />}
        modal
        nested
      >
        {(close) => (
          <div className="PopupInfoContent">
            <h3>{product_title}</h3>
            <span></span>
            <h2></h2>
            <h2>Weight: {product_mass}kg</h2>
            <h2>Cost: R{product_price}</h2>
          </div>
        )}
      </Popup>
    </div>
  );
}
export default ShoppableCard;
