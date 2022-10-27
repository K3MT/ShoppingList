import React from "react";
import { useEffect, useState } from "react";
import "./FriendComponent.css";
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

function FriendComponent({
  stateChanger,
  friend_imageurl,
  friend_name,
  following_ID,
  friend_productCount,
  user_id,
}) {
  function setToFocused() {
    stateChanger(following_ID);
  }

  return (
    <div className="friendTile">
      <div
        className="imageholder"
        style={{
          width: "30%",
          height: "75px",
          marginTop: "-13.5%",
          backgroundSize: "100% 100%",
          borderRadius: "5em",
          backgroundImage: `url(${friend_imageurl}), url("https://i.imgur.com/CjnIMqJ.png")`,
        }}
      ></div>
      <div>
        <h3 className="friendName">{friend_name}</h3>
      </div>
      {/* <div>
        <h3 className="friendCount"></h3>
      </div> */}
      {/* <div className="friendEnterIcon">
        <GrView className="friendEnterIconButton" />
      </div> */}
      <div className="viewButtons">
        <div className="viewprofileBtn" onClick={setToFocused}>
          View Profile
        </div>
      </div>
    </div>
  );
}
export default FriendComponent;
