import React, { useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import "./Profile.css";
// import "./Home.css";
import ShoppableCard from "./ShoppableCard.js";
import axios from "axios";
import { Dialog } from "primereact/dialog";
import { InputText } from "primereact/inputtext";

export default function Profile(props) {
  const { state } = useLocation();
  const [isResponse, setResponse] = useState(false);
  const [listArray, setListArray] = useState([]);
  const [categoryArray, setcategoryArray] = useState([]);
  const [currcategoryFilter, setcategoryFilter] = useState("Unfiltered");
  const [currSortOrder, setSortOrder] = useState("Unordered");
  const [userInfo, setUserInfo] = useState([
    { name: "", surname: "", userAboutMe: "", userImageURL: "" },
  ]);
  const [stateChange, setstatechange] = useState(0);
  const [userInfofectched, setuserinfofecthed] = useState(true);
  const [image, setImage] = useState("");

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
      .post("https://k3mt-backend.herokuapp.com//src/GetAllItems.php", {
        data: [],
      })
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
  const toEditProfile = () => {
    navigate("/editprofile", { state: { userID: state.userID } });
  };

  const profileToCart = () => {
    navigate("/cart", { state: { userID: state.userID } });
  };

  return (
    <div className="Auth-form-container">
      <div class="Proarea">
        <ul class="Procircles">
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
      <span>

      <a href="#" class="logo"> <i class="fas fa-shopping-basket"></i> K3MT </a>
      <nav class="navMenu">
        
          <a href="#">Sort By</a>
          <a href="#" >
            Filter
          </a>
          <a href="#">Profile
            
          
            
          </a>
          <a href="" onClick={profileToCart}>
            Cart
          </a>
  
          
          
        </nav>
      </span>

      <div className="shoppableItems">
      <section class="home" id="home">

      <div class="content">
          <h3>fresh and <span>organic</span> products for you</h3>
      </div>

      </section>
        {isResponse &&
          listArray.map((item) => {
            if (currcategoryFilter == "Unfiltered") {
              return (
                <ShoppableCard
                  product_title={item.itemName}
                  product_ID={item.itemID}
                  product_imageurl={item.itemImageURL}
                  product_price={item.itemPrice}
                  product_mass={item.itemMass}
                  product_brandID={item.brandID}
                  product_description={item.itemDescription}
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
