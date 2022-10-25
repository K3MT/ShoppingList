import React from "react";
import { useEffect, useState } from "react";
import "./ShoppableCard.css";
import { useHistory } from "react-router-dom";
import axios from "axios";
import { BsInfoCircle } from "react-icons/bs";
import Popup from "reactjs-popup";
import "reactjs-popup/dist/index.css";
import { ToastContainer, toast } from "react-toastify";
import { RiMoneyDollarBoxFill } from "react-icons/ri";
import "react-toastify/dist/ReactToastify.css";
import Lottie from "lottie-react";
import { useLottie } from "lottie-react";
import addedToCartAnim from "./lotties/cartAdded.json";

//TODO smooth out hover animation using css

function ShoppableCard({
  product_title,
  product_ID,
  product_imageurl,
  product_price,
  product_mass,
  product_unit,
  product_brandID,
  product_description,
  user_id,
}) {
  useEffect(() => {
    window.scroll(0, 0);
  }, []);

  function addTocart() {
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
        playCartAdded();
        // toast.success("Successfully added to cart");
      });
  }

  function addTotemplate() {
    const data = {
      userID: user_id,
      itemID: product_ID,
      typeTemplate: "true",
      typeCart: "false",
      typePublic: "false",
    };
    axios
      .post("https://k3mt-backend.herokuapp.com/src/AddItemToList.php", {
        data: data,
      })
      .then((result) => {
        playCartAdded();
        // toast.success("Successfully added to cart");
      });
  }

  const playCartAdded = () => {
    let anim = document.getElementById(product_ID);
    anim.style.visibility = "visible";
    setTimeout(hidecartadded, 1000);
  };

  function hidecartadded() {
    let anim = document.getElementById(product_ID);
    anim.style.visibility = "hidden";
  }

  return (
    <div className="Tile">
      <h3 id="prodTitle" className="Title">
        {product_title}
      </h3>
      <div className="shoppablePriceSection">
        <RiMoneyDollarBoxFill className="shoppablePriceIcon" />
        <h3 className="shoppablePrice">R{product_price}</h3>
      </div>
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
      <ToastContainer />
      <button className="addProfileButton" onClick={addTocart}>
        <h3>Add to Cart</h3>
      </button>
      <button className="templateProfileButton" onClick={addTotemplate}>
        <h3>Add to template</h3>
      </button>
      <Lottie
        animationData={addedToCartAnim}
        height={100}
        loop={false}
        width={100}
        autoPlay={false}
        id={product_ID}
        className="addedAnim"
      />
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
            <h2>Units: {product_mass}{product_unit}</h2>
            <h2>Cost: R{product_price}</h2>
          </div>
        )}
      </Popup>
    </div>
  );
}
export default ShoppableCard;