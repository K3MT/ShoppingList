import React from "react";
import { useEffect, useState } from "react";
import "./ShoppableCard.css";
import { useHistory } from "react-router-dom";
import axios from "axios";
import { BsInfoCircle } from "react-icons/bs";
import Popup from "reactjs-popup";
import "reactjs-popup/dist/index.css";
import { ToastContainer, toast } from "react-toastify";
import 'react-toastify/dist/ReactToastify.css';

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
        toast.success("Successfully added to cart");
        // window.alert("Successfully added to cart");
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
        toast.success("Successfully added to template");
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
          width: "100%",
          height: "60%",
          backgroundSize: "100% 100%",
          borderRadius: "1em",
          backgroundImage: `url(${product_imageurl})`,
        }}
      ></div>
      <ToastContainer/>
      <button className="btn" onClick={addTocart}>
        Add to cart
      </button>
      <button className="btn" onClick={addTotemplate}>
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
