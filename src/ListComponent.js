import React from "react";
import { useEffect, useState } from "react";
import "./ListComponent.css";
import { useHistory, useLocation, useNavigate } from "react-router-dom";
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

function ListComponent({ list_name, user_id, list_id, list_imageUrl }) {
  const navigate = useNavigate();
  const viewList = () => {
    navigate("/userlistcreation", {
      state: {
        userID: user_id,
        listName: list_name,
        listID: list_id,
        viewMode: "currentUser",
      },
    });
  };
  return (
    <div className="listTile">
      <div
        className="imageholder"
        style={{
          width: "15rem",
          height: "13.5rem",
          marginTop: "-6.25%",
          backgroundSize: "100% 100%",
          borderRadius: "1.5em",
          backgroundImage: `url(${list_imageUrl})`,
        }}
      ></div>
      <div>
        <h3 className="listName">{list_name}</h3>
      </div>

      <div className="listEnterIcon" onClick={viewList}>
        <GrView className="listEnterIconButton" />
      </div>
    </div>
  );
}
export default ListComponent;
