import React from "react";
import { useEffect, useState } from "react";
import "./ListComponent.css";
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

function ListComponent({ list_name, user_id, list_id }) {
  let list_imageurl = "";
  let listCount = 0;
  return (
    <div className="listTile">
      <div
        className="imageholder"
        style={{
          width: "25%",
          height: "310%",
          marginTop: "-4.25%",
          backgroundSize: "100% 100%",
          borderRadius: "1.5em",
          backgroundImage: `url(${list_imageurl})`,
        }}
      ></div>
      <div>
        <h3 className="listName">{list_name}</h3>
      </div>
      <div>
        <h3 className="listCount">{list_id}</h3>
      </div>
      <div className="listEnterIcon">
        <GrView className="listEnterIconButton" />
      </div>
    </div>
  );
}
export default ListComponent;
