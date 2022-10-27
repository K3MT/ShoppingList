import React, { useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import "./ProfileManagement.css";
import "./ListComponent.js";
import "./RequestComponent.js";
import axios from "axios";
import ListComponent from "./ListComponent.js";
import RequestComponent from "./RequestComponent.js";
import DiscoverComponent from "./DiscoverComponent.js";
import FriendComponent from "./FriendComponent.js";
import FriendListComponent from "./FriendListComponent";
import Lottie from "lottie-react";
import { useLottie } from "lottie-react";
import emptyBoxAnim from "./lotties/emptyBox.json";
import noDataAnim from "./lotties/noData.json";

import {
  AiOutlineEdit,
  AiOutlineShoppingCart,
  AiOutlineHome,
  AiFillCloseCircle,
} from "react-icons/ai";
import { isElementType } from "@testing-library/user-event/dist/utils";
export default function ProfileManagement(props) {
  //Use to extract information sent from other page.
  const { state } = useLocation();

  //state variable will be changed to Focused when viewing an individual user.
  var [viewmode, setviewMode] = useState("Normal");
  const [listArray, setListArray] = useState([]);
  const [focusedlistArray, setfocusedListArray] = useState([]);
  const [friendsArray, setfriendsArray] = useState([]);
  const [recommendedArray, setrecommendedArray] = useState([]);
  const [reqsArray, setreqsArray] = useState([]);
  const [selectedUserInfo, setselectedUserInfo] = useState([]);
  const [stateChange, setstatechange] = useState(0);
  const [staterecomChange, setstaterecomchange] = useState(0);
  const [statereqsChange, setstatereqschange] = useState(0);
  const [statefriendsChange, setstatefriendschange] = useState(0);
  const [isResponse, setResponse] = useState(false);
  const [isfriendsResponse, setfriendsResponse] = useState(false);
  const [isrecomResponse, setrecomResponse] = useState(false);
  const [isreqsResponse, setreqsResponse] = useState(false);
  const [focusedlistResponse, setfocusedlistResponse] = useState(false);
  const [selectedUser, setselectedUser] = useState("");
  const [myListEmpty, setmyListEmpty] = useState(false);
  const [myFriendsEmpty, setmyFriendsEmpty] = useState(false);
  const [myReqsEmpty, setmyReqsEmpty] = useState(false);
  const [myFocusedListEmpty, setmyFocusedListEmpty] = useState(false);
  const [selectedUserInfoFetched, setselectedUserInfoFetched] = useState(false);

  const navigate = useNavigate();

  useEffect(() => {
    let mounted = true;
    let data = { followerID: state.userID };
    let url = "https://k3mt-backend.herokuapp.com//src/GetUsersToFollow.php";
    axios
      .post(url, {
        data: data,
      })
      .then((result) => {
        if (mounted) {
          console.log(result.data);
          setrecommendedArray(Array.from(result.data));
          setrecomResponse(true);
        }
        return () => (mounted = false);
      });
  }, [staterecomChange]);

  useEffect(() => {
    let mounted = true;
    let data = { influencerID: state.userID };
    let url = "https://k3mt-backend.herokuapp.com//src/GetFollowerMetadata.php";
    axios
      .post(url, {
        data: data,
      })
      .then((result) => {
        if (mounted) {
          setfriendsArray(Array.from(result.data));
          setfriendsResponse(true);
          if (result.data.length == 0) {
            setmyFriendsEmpty(true);
          }
          if (result.data[0].length == 1) {
            setmyFriendsEmpty(true);
          }
          if (result.data.length > 0) {
            setmyFriendsEmpty(false);
          }
        }
        return () => (mounted = false);
      });
  }, [statefriendsChange]);

  useEffect(() => {
    let mounted = true;
    let data = { userID: state.userID };
    let url = "https://k3mt-backend.herokuapp.com//src/GetFollowRequests.php";
    axios
      .post(url, {
        data: data,
      })
      .then((result) => {
        if (mounted) {
          setreqsArray(Array.from(result.data));
          setreqsResponse(true);
          if (result.data.length == 0) {
            setmyReqsEmpty(true);
          }
          if (result.data[0].length == 1) {
            setmyReqsEmpty(true);
          }
          if (result.data.length > 0) {
            setmyReqsEmpty(false);
          }
        }
        return () => (mounted = false);
      });
  }, [statereqsChange]);

  useEffect(() => {
    let mounted = true;
    let data = { userID: selectedUser };
    let url = "https://k3mt-backend.herokuapp.com//src/GetUserListMetadata.php";
    axios
      .post(url, {
        data: data,
      })
      .then((result) => {
        if (mounted) {
          setfocusedListArray(Array.from(result.data));
          setfocusedlistResponse(true);
          if (result.data.length == 0) {
            setmyFocusedListEmpty(true);
          } else {
            if (result.data[0].length == 1) {
              setmyFocusedListEmpty(true);
            }
          }
        }
        return () => (mounted = false);
      });
  }, [selectedUser]);

  useEffect(() => {
    let mounted = true;
    let data = { userID: state.userID };
    let url = "https://k3mt-backend.herokuapp.com//src/GetUserListMetadata.php";
    axios
      .post(url, {
        data: data,
      })
      .then((result) => {
        if (mounted) {
          setListArray(Array.from(result.data));
          setResponse(true);
          console.log(result.data);
          if (result.data.length == 0) {
            setmyListEmpty(true);
          } else {
            if (result.data[0].length == 1) {
              setmyFriendsEmpty(true);
            }
          }
        }
        return () => (mounted = false);
      });
  }, [stateChange]);

  useEffect(() => {
    let data = { userID: selectedUser };
    let url = "https://k3mt-backend.herokuapp.com//src/GetUserDetails.php";
    axios
      .post(url, {
        data: data,
      })
      .then((result) => {
        setselectedUserInfo(Array.from(result.data));
        setselectedUserInfoFetched(true);
      });
  }, [selectedUser]);

  const changeViewMode = () => {
    if (viewmode == "Normal") {
      setviewMode("Focused");
    } else {
      setselectedUserInfoFetched(false);
      setselectedUserInfo([]);
      setfocusedListArray([]);
      setmyFocusedListEmpty(false);
      setfocusedlistResponse(false);
      setviewMode("Normal");
    }
  };

  const setFocusToUser = (focusID) => {
    setselectedUser(focusID);
    changeViewMode();
  };

  const requestStateChange = () => {
    setstatereqschange(statereqsChange + 1);
    setstatefriendschange(statefriendsChange + 1);
  };

  const recomStateChange = () => {
    setstaterecomchange(staterecomChange + 1);
  };

  const toListCreation = () => {
    navigate("/listcreationinter", { state: { userID: state.userID } });
  };

  const managementToProfile = () => {
    navigate("/profile", { state: { userID: state.userID } });
  };

  //Return page according to set view mode.
  if (viewmode == "Normal") {
    return (
      <div className="Auth-form-container-management">
        <div className="mainarea">
          <div className="mylistsarea">
            <div className="listsTitle">
              <h3>My lists</h3>
            </div>
            <div className="toProfileButton" onClick={managementToProfile}>
              <h3>Done</h3>
            </div>
            <div className="listsList">
              {isResponse &&
                listArray.map((item) => {
                  return (
                    <ListComponent
                      list_name={item.listName}
                      list_imageUrl={item.listImageURL}
                      list_id={item.listID}
                      user_id={state.userID}
                    />
                  );
                })}
            </div>
            {myListEmpty && (
              <Lottie
                animationData={emptyBoxAnim}
                height={100}
                loop={false}
                width={100}
                autoPlay={true}
                className="emptyBoxAnimstyle"
              />
            )}
            <div className="createlistBtn" onClick={toListCreation}>
              <h3>Create List</h3>
            </div>
          </div>
          <div className="peoplearea">
            <div className="discoverarea">
              <div className="discoverTitle">
                <h3>Available Users</h3>
              </div>

              <div className="discoverList">
                {isrecomResponse &&
                  recommendedArray.map((item) => {
                    if (item.userID != state.userID) {
                      return (
                        <DiscoverComponent
                          stateChanger={recomStateChange}
                          discover_name={item.name + " " + item.surname}
                          discover_aboutMe={item.userAboutMe}
                          discover_imageurl={item.userImageURL}
                          following_id={item.userID}
                          user_id={state.userID}
                        />
                      );
                    }
                  })}
              </div>
            </div>
            <div className="reqsandfollowingarea">
              <div className="reqsarea">
                <div className="reqsTitle">
                  <h3>Friend requests</h3>
                </div>
                <div className="reqsareaList">
                  {isreqsResponse &&
                    reqsArray.map((item) => {
                      return (
                        <RequestComponent
                          stateChanger={requestStateChange}
                          request_name={item.name + " " + item.surname}
                          request_imageurl={item.userImageURL}
                          user_id={state.userID}
                          following_id={item.userID}
                        />
                      );
                    })}
                </div>
                {myReqsEmpty && (
                  <Lottie
                    animationData={noDataAnim}
                    height={100}
                    loop={false}
                    width={100}
                    autoPlay={true}
                    // id={product_ID}
                    className="reqsEmptyAnim"
                  />
                )}
              </div>
              <div className="followingarea">
                <div className="followingareaTitle">
                  <h3>Friends</h3>
                </div>
                <div className="followingareaList">
                  {isfriendsResponse &&
                    friendsArray.map((item) => {
                      return (
                        <FriendComponent
                          stateChanger={setFocusToUser}
                          friend_name={item.name + " " + item.surname}
                          friend_imageurl={item.userImageURL}
                          user_id={state.userID}
                          following_ID={item.userID}
                        />
                      );
                    })}
                </div>
                {myFriendsEmpty && (
                  <Lottie
                    animationData={noDataAnim}
                    height={100}
                    loop={false}
                    width={100}
                    autoPlay={true}
                    // id={product_ID}
                    className="noFriendsAnim"
                  />
                )}
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
  //Only render the component after the selected user info has been feteched or youll end up rendering previous data!!!!!
  else {
    return (
      <div className="Auth-form-container-management">
        <div className="mainarea">
          <div className="mylistsarea">
            <div className="listsTitle">
              <h3>My lists</h3>
            </div>
            <div className="listsList">
              {isResponse &&
                listArray.map((item) => {
                  return (
                    <ListComponent
                      list_name={item.listName}
                      list_imageUrl={item.listImageURL}
                      list_id={item.listID}
                      user_id={state.userID}
                    />
                  );
                })}
            </div>
            {myListEmpty && (
              <Lottie
                animationData={emptyBoxAnim}
                height={100}
                loop={false}
                width={100}
                autoPlay={true}
                className="emptyBoxAnimstyle"
              />
            )}
          </div>
          <div className="focusedArea">
            {selectedUserInfoFetched && (
              <div className="focusedInfo">
                <div
                  className="focusedimageholder"
                  style={{
                    width: "30%",
                    height: "97%",
                    marginTop: "0.05em",
                    backgroundSize: "100% 100%",
                    borderRadius: "2em",
                    backgroundImage: `url(${selectedUserInfo[0].userImageURL}), url("https://i.imgur.com/CjnIMqJ.png")`,
                  }}
                ></div>
                <div className="closefocused">
                  <AiFillCloseCircle
                    className="closefocusedIconButton"
                    onClick={changeViewMode}
                  />
                </div>
                <div className="focusedName">
                  <h3>
                    {selectedUserInfo[0].name} {selectedUserInfo[0].surname}
                  </h3>
                  <h1>{selectedUserInfo[0].userAboutMe}</h1>
                </div>
              </div>
            )}
            <div className="focusedlistsTitle">
              <h3>User's lists</h3>
            </div>
            <div className="focusedlistsList">
              {focusedlistResponse &&
                focusedlistArray.map((item) => {
                  if (item.listName) {
                    return (
                      <FriendListComponent
                        friendlist_name={item.listName}
                        friendlist_imageUrl={item.listImageURL}
                        friendlist_id={item.listID}
                        user_id={state.userID}
                      />
                    );
                  }
                })}
            </div>
          </div>
        </div>
      </div>
    );
  }
}
