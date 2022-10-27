import React from "react";
import { useEffect, useState } from "react";
import "./UserListItem.css";
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

function UserListItem({
  stateChanger,
  product_name,
  product_ID,
  product_imageurl,
  product_price,
  product_count,
  list_ID,
  user_id,
}) {
  function removeFromList() {
    const data = {
      listID: list_ID,
      itemID: product_ID,
    };
    axios
      .post("https://k3mt-backend.herokuapp.com/src/RemoveItemFromList.php", {
        data: data,
      })
      .then((result) => {
        console.log(result.data);
        console.log(result.data);

        stateChanger();
      });
  }

  return (
    <div className="userlistTile">
      <h3 id="userlistTitle" className="userlistTitle">
        {product_name}
      </h3>
      <div className="userlistPriceSection">
        <RiMoneyDollarBoxFill className="userlistPriceIcon" />
        <h3 className="shoppablePrice">R{product_price}</h3>
        <h3 className="shoppableCount">{product_count}x</h3>
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
      <button className="removeuserlistButton" onClick={removeFromList}>
        <h3>Remove</h3>
      </button>
    </div>
  );
}
export default UserListItem;
