import React from "react";
import { useEffect, useState } from "react";
import "./RequestComponent.css";
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

function RequestComponent({
  stateChanger,
  request_imageurl,
  request_name,
  // request_productCount,
  user_id,
  following_id,
}) {
  const reqsstateChange = () => {
    stateChanger();
  };

  const acceptRequest = () => {
    let data = { influencerUserID: user_id, followerUserID: following_id };
    let url = "https://k3mt-backend.herokuapp.com//src/AcceptFollowRequest.php";
    axios
      .post(url, {
        data: data,
      })
      .then((result) => {
        stateChanger();
      });
  };

  const rejectRequest = () => {
    let data = { influencerUserID: user_id, followerUserID: following_id };
    let url = "https://k3mt-backend.herokuapp.com//src/RejectFollowRequest.php";
    axios
      .post(url, {
        data: data,
      })
      .then((result) => {
        stateChanger();
      });
  };

  return (
    <div className="requestTile">
      <div
        className="imageholder"
        style={{
          width: "26%",
          height: "65px",
          marginTop: "-5%",
          backgroundSize: "100% 100%",
          borderRadius: "1.5em",
          backgroundImage: `url(${request_imageurl}), url("https://i.imgur.com/CjnIMqJ.png")`,
        }}
      ></div>
      <div>
        <h3 className="requestName">{request_name}</h3>
      </div>
      {/* <div>
        <h3 className="requestCount">Jou pa</h3>
      </div> */}
      {/* <div className="requestEnterIcon">
        <GrView className="requestEnterIconButton" />
      </div> */}
      <div className="replyButtons">
        <div className="acceptBtn" onClick={acceptRequest}>
          <h3>Accept</h3>
        </div>
        <div className="rejectBtn" onClick={rejectRequest}>
          <h3>Reject</h3>
        </div>
      </div>
    </div>
  );
}
export default RequestComponent;
