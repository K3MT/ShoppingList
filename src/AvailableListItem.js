import React from "react";
import { useEffect, useState } from "react";
import "./AvailableListItem.css";
import { useHistory } from "react-router-dom";
import axios from "axios";
import { BsInfoCircle } from "react-icons/bs";
import Popup from "reactjs-popup";
import "reactjs-popup/dist/index.css";
import { ToastContainer, toast } from "react-toastify";
import { RiMoneyDollarBoxFill } from "react-icons/ri";
import { IoEnterOutline } from "react-icons/io";
import { GrView } from "react-icons/gr";
import "react-toastify/dist/ReactToastify.css";

//TODO smooth out hover animation using css

function AvailableListItem({
  stateChanger,
  product_imageurl,
  product_name,
  product_ID,
  product_price,
  user_id,
  list_ID,
}) {
  const addToList = () => {
    const data = {
      listID: list_ID,
      itemID: product_ID,
    };
    axios
      .post("https://k3mt-backend.herokuapp.com/src/AddItemToList.php", {
        data: data,
      })
      .then((result) => {
        console.log(result.data);
        stateChanger();
      });
  };

  return (
    <div className="availableTile">
      <div
        className="imageholder"
        style={{
          width: "30%",
          height: "75px",
          marginTop: "-10.5%",
          backgroundSize: "100% 100%",
          borderRadius: "2em",
          backgroundImage: `url(${product_imageurl})`,
        }}
      ></div>
      <div>
        <h3 className="availableName">{product_name}</h3>
      </div>
      <div>
        <h3 className="availablePrice">R{product_price}</h3>
      </div>
      <div className="availableButtons">
        <div className="availableBtn" onClick={addToList}>
          Add
        </div>
      </div>
    </div>
  );
}
export default AvailableListItem;
