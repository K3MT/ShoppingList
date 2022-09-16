import React, { useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import "./Profile.css";
import ShoppableCard from "./ShoppableCard.js";
import axios from "axios";
export default function Profile(props) {
  const { state } = useLocation();
  const [isResponse, setResponse] = useState(false);
  const [listArray, setListArray] = useState([]);
  const [categoryArray, setcategoryArray] = useState([]);
  const [currcategoryFilter, setcategoryFilter] = useState("Unfiltered");
  const [currSortOrder, setSortOrder] = useState("Unordered");
  const [userInfo, setUserInfo] = useState([{name:"",surname:"",userAboutMe:"",userImageURL:""}]);
  const [stateChange, setstatechange] = useState(0);
  const [userInfofectched, setuserinfofecthed] = useState(true);

  //get the different categories
  const categoryArrayupdate = () => {
    let curr = ["Unfiltered"];
    for (let index = 0; index < listArray.length; index++) {
      if (!curr.includes(listArray.at(index).categoryName)) {
        curr.push(listArray.at(index).categoryName);
      }
    }
    setcategoryArray(curr);
  };
  //Update userInfo

  //Catch request response from server
  useEffect(() => {
    let mounted = true;
    let data = {
      userID: state.userID,
    };
    axios
      .post(
        "https://k3mt-shopping-list-backend.herokuapp.com/src/GetUserDetails.php",
        {
          data: data,
        }
      )
      .then((result) => {
        setuserinfofecthed(true);
        console.log(result.data);
        setUserInfo(result.data);
      });
  }, []);

  //Catch request response from server
  useEffect(() => {
    let mounted = true;
    axios
      .post(
        "https://k3mt-shopping-list-backend.herokuapp.com/src/GetAllItems.php",
        {
          data: [],
        }
      )
      .then((result) => {
        if (mounted) {
          if (currSortOrder == "Ascending") {
            result.data.sort(function (a, b) {
              return parseFloat(a.itemPrice) - parseFloat(b.itemPrice);
            });
          }
          if (currSortOrder == "Descending") {
            result.data.sort(function (a, b) {
              return parseFloat(b.itemPrice) - parseFloat(a.itemPrice);
            });
          }
          categoryArrayupdate();
          setListArray(Array.from(result.data));
          setResponse(true);
        }
        return () => (mounted = false);
      });
  }, [stateChange, categoryArray]);

  const categoryFilter = (categoryName) => {
    setcategoryFilter(categoryName);
    setstatechange(stateChange + 1);
  };

  const setOrder = (order) => {
    console.log("called");
    setSortOrder(order);
    setstatechange(stateChange + 1);
  };

  let navigate = useNavigate();
  const toEditProfile =()=>{
    navigate("/editprofile", { state: { userID: state.userID } });
  }

  const profileToCart =()=>{
    navigate("/cart");
  }

  return (
    <div className="Auth-form-container">
      <div class="area">
        <ul class="circles">
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
        </ul>
      </div>
      <div class="ProfileArea">
        <div class="card">
          <div class="contentBx">
            <h2>Profile</h2>
            <div
        style={{
          width: "90%",
          marginLeft: "5%",
          height: "200px",
          backgroundSize: "cover",
          borderRadius: "1em",
          backgroundImage: `url(${userInfo[0].userImageURL})`,
        }}
      ></div>
            <h2>Name:{userInfo[0].name}</h2>
            <h2>Surname:{userInfo[0].surname}</h2>
            <h2>Bio:{userInfo[0].userAboutMe}</h2>
            <button className="editProfileBtn" onClick={toEditProfile}>
              Edit
            </button>    
          </div>
        </div>
        
        <span class="cartBtn">
          <a onClick={profileToCart}></a>
        </span>
      </div>

      <div class="sec-center">
        <input
          class="dropdown"
          type="checkbox"
          id="dropdown-filter"
          name="dropdown"
        />
        <label class="for-dropdown" for="dropdown-filter">
          Filter Options <i class="uil uil-arrow-down"></i>
        </label>
        <div class="section-dropdown">
          <input
            class="dropdown-sub"
            type="checkbox"
            id="dropdown-sub"
            name="dropdown-sub"
          />
          <label class="for-dropdown-sub" for="dropdown-sub">
            Filter by type <i class="uil uil-plus"></i>
          </label>
          <div class="section-dropdown-sub">
            {categoryArray.map((category) => {
              const catcher = () => {
                categoryFilter(category);
              };
              return (
                <a onClick={catcher}>
                  {category}
                  <i class="uil uil-arrow-right"></i>
                </a>
              );
            })}
          </div>
        </div>
      </div>

      <div class="sec-center-sort">
        <input
          class="dropdown"
          type="checkbox"
          id="dropdown-sort"
          name="dropdown"
        />
        <label class="for-dropdown" for="dropdown-sort">
          Sort Options <i class="uil uil-arrow-down"></i>
        </label>
        <div class="section-dropdown">
          <input
            class="dropdown-sub"
            type="checkbox"
            id="dropdown-sub-sort"
            name="dropdown-sub"
          />
          <label class="for-dropdown-sub" for="dropdown-sub-sort">
            Sort by price <i class="uil uil-plus"></i>
          </label>
          <div class="section-dropdown-sub">
            {["Unordered", "Ascending", "Descending"].map((order) => {
              const catcher = () => {
                setOrder(order);
              };
              return (
                <a onClick={catcher}>
                  {order}
                  <i class="uil uil-arrow-right"></i>
                </a>
              );
            })}
          </div>
        </div>
      </div>

      <div className="shoppableItems">
        {isResponse &&
          listArray.map((item) => {
            if (currcategoryFilter == "Unfiltered") {
              return (
                <ShoppableCard
                  title={item.itemName}
                  keyy={item.itemID}
                  imageurl={item.itemImageURL}
                  game_id={item.itemPrice}
                  tournament_id={item.itemMass}
                  arbTourney={item.itemMass}
                  setArbtourney={item.brandID}
                  user_id={state.userID}
                />
              );
            } else {
              if (item.categoryName == currcategoryFilter) {
                return (
                  <ShoppableCard
                    title={item.itemName}
                    keyy={item.itemID}
                    imageurl={item.itemImageURL}
                    game_id={item.itemPrice}
                    tournament_id={item.itemMass}
                    arbTourney={item.itemMass}
                    setArbtourney={item.brandID}
                    user_id={state.userID}
                  />
                );
              }
            }
          })}
      </div>
    </div>
  );
}
