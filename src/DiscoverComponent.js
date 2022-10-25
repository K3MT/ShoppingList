import React from "react";
import { useEffect, useState } from "react";
import "./DiscoverComponent.css";
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

function DiscoverComponent({
  stateChanger,
  discover_imageurl,
  discover_name,
  discover_aboutMe,
  discover_productCount,
  user_id,
  following_id,
}) {
  const [infostateChange, setinfostateChange] = useState(0);
  const [fetchCount, setfetchCount] = useState(0);

  const sendFollowRequest = () => {
    let data = { influencerUserID: following_id, followerUserID: user_id };
    let url = "https://k3mt-backend.herokuapp.com//src/SendFollowRequest.php";
    axios
      .post(url, {
        data: data,
      })
      .then((result) => {
        stateChanger();
      });
  };

  return (
    <div>
      <div className="discoverTile">
        <div
          className="imageholder"
          style={{
            width: "25%",
            height: "170%",
            marginTop: "-3.9%",
            backgroundSize: "100% 100%",
            borderRadius: "150em",
            backgroundImage: `url(${discover_imageurl}), url("https://i.imgur.com/CjnIMqJ.png")`,
          }}
        ></div>
        <div>
          <h3 className="discoverName">{discover_name}</h3>
        </div>
        <div>
          <h3 className="discoverCount">{discover_aboutMe}</h3>
        </div>
        <div className="sendrequestBtn" onClick={sendFollowRequest}>
          Invite
        </div>
      </div>
    </div>
  );
}
export default DiscoverComponent;
