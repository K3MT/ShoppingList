import React from "react";
import { useEffect, useState } from "react";
import "./OtherListItem.css";
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

function OtherListItem({
  stateChanger,
  product_name,
  product_ID,
  product_imageurl,
  product_price,
  list_ID,
  product_count,
  Other_id,
}) {
  return (
    <div className="otherlistTile">
      <h3 id="otherlistTitle" className="otherlistTitle">
        {product_name}
      </h3>
      <div className="otherlistPriceSection">
        <RiMoneyDollarBoxFill className="otherlistPriceIcon" />
        <h3 className="shoppablePrice">R{product_price}</h3>
        <h3 className="shoppableCount">{product_count}x</h3>
      </div>
      <div
        className="imageholder"
        style={{
          width: "100%",
          height: "75%",
          backgroundSize: "100% 100%",
          borderRadius: "1em",
          backgroundImage: `url(${product_imageurl})`,
        }}
      ></div>
    </div>
  );
}
export default OtherListItem;
