import React from "react";
import { useEffect, useState } from "react";
import "./FriendListComponent.css";
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

function FriendListComponent({
  friendlist_name,
  user_id,
  friendlist_id,
  friendlist_imageUrl,
}) {
  const navigate = useNavigate();
  const viewfriendlist = () => {
    navigate("/userlistcreation", {
      state: {
        userID: user_id,
        listName: friendlist_name,
        listID: friendlist_id,
        viewMode: "otherUser",
      },
    });
  };
  return (
    <div className="friendlistTile">
      <div
        className="imageholder"
        style={{
          width: "15rem",
          height: "13.5rem",
          marginTop: "-6.25%",
          backgroundSize: "100% 100%",
          borderRadius: "1.5em",
          backgroundImage: `url(${friendlist_imageUrl})`,
        }}
      ></div>
      <div>
        <h3 className="friendlistName">{friendlist_name}</h3>
      </div>

      <div className="friendlistEnterIcon" onClick={viewfriendlist}>
        <GrView className="friendlistEnterIconButton" />
      </div>
    </div>
  );
}
export default FriendListComponent;
