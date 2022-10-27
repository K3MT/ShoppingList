import React, { useCallback, useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import "./Profile.css";
import {
  AiOutlineEdit,
  AiOutlineShoppingCart,
  AiOutlineHome,
} from "react-icons/ai";
import { GiMilkCart, GiSlicedBread, GiSodaCan } from "react-icons/gi";
import { BiDrink } from "react-icons/bi";
import {
  TbMilk,
  TbBread,
  TbSortAscendingNumbers,
  TbSortDescendingNumbers,
  TbSortAscending2,
  TbSortDescending2,
} from "react-icons/tb";
import { FaRandom } from "react-icons/fa";
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
  const [productMode, setproductMode] = useState("All");

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
      .post("https://k3mt-backend.herokuapp.com//src/GetUserDetails.php", {
        data: data,
      })
      .then((result) => {
        setuserinfofecthed(true);
        setUserInfo(result.data);
      });
  }, []);

  //Catch request response from server
  useEffect(() => {
    let mounted = true;
    let data = {};
    let url = "https://k3mt-backend.herokuapp.com//src/GetAllItems.php";
    if (productMode == "Recommended") {
      url = "https://k3mt-backend.herokuapp.com//src/GetRecommendedItems.php";
      data = { userID: state.userID };
    }
    if (productMode == "Specials") {
      url = "https://k3mt-backend.herokuapp.com//src/GetItemsOnSpecial.php";
    }
    if (productMode == "TopItems") {
      url = "https://k3mt-backend.herokuapp.com//src/GetPopularItems.php";
    }
    axios
      .post(url, {
        data: data,
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
    setSortOrder(order);
    setstatechange(stateChange + 1);
  };

  const setMode = (mode) => {
    setproductMode(mode);
    setstatechange(stateChange + 1);
  };

  let navigate = useNavigate();

  const toEditProfile = () => {
    navigate("/editprofile", {
      state: {
        userID: state.userID,
        userAboutMe: userInfo[0].userAboutMe,
        userImageURL: userInfo[0].userImageURL,
      },
    });
  };

  const profileToCart = () => {
    navigate("/cart", { state: { userID: state.userID } });
  };

  const profileToManagement = () => {
    navigate("/management", { state: { userID: state.userID } });
  };

  const logOut = () => {
    navigate("/login");
  };

  return (
    <div className="Auth-form-container">
      <div className="Proarea">
        <ul className="Procircles">
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
        {/* <a href="#" class="logo">
          {" "}
          <i class="fas fa-shopping-basket"></i> K3MT{" "}
        </a> */}
        <nav class="navMenu">
          <AiOutlineShoppingCart
            className="CartIconButton"
            id="CartIconButton"
            onClick={profileToCart}
          />
          <AiOutlineHome
            className="HomeIconButton"
            id="HomeIconButton"
            onClick={profileToManagement}
          />
        </nav>
      </span>
      <section className="profile" id="home">
        <div class="categories">
          <div className="random" onClick={() => categoryFilter("Unfiltered")}>
            <FaRandom className="RandomIcon" />
            <h3>Random</h3>
          </div>

          <div className="dairy" onClick={() => categoryFilter("Dairy")}>
            <TbMilk className="DairyIcon" />
            <h3>Dairy</h3>
          </div>

          <div className="beverage" onClick={() => categoryFilter("Beverages")}>
            <BiDrink className="BeverageIcon" />
            <h3>Beverages</h3>
          </div>

          <div className="bread" onClick={() => categoryFilter("Bread")}>
            <TbBread className="BreadIcon" />
            <h3>Bread</h3>
          </div>
        </div>
        <div class="sorting">
          <h3>Sort by price</h3>
          <div className="ascending" onClick={() => setOrder("Ascending")}>
            <h4>Ascending</h4>
            <TbSortAscending2 className="AscendingIcon" />
          </div>
          <div className="descending" onClick={() => setOrder("Descending")}>
            <h4>Descending</h4>
            <TbSortDescending2 className="DescendingIcon" />
          </div>
          <div className="random" onClick={() => setOrder("Unsorted")}>
            <h4>Unsorted </h4>
            <FaRandom className="RandomIcon" />
          </div>
        </div>
      </section>
      <div className="profileBox">
        <div
          className="imageSection"
          style={{
            width: "35%",
            height: "100px",
            margin: "1%",
            backgroundSize: "100% 100%",
            borderRadius: "1.5em",
            color: "black",
            backgroundImage: `url(${userInfo[0].userImageURL})`,
          }}
        ></div>

        <div className="infoSection">
          <h1>
            {userInfo[0].name} {userInfo[0].surname}
          </h1>

          <h3>{userInfo[0].userAboutMe}</h3>
          <div className="logoutButton" onClick={logOut}>
            <h3>Sign Out</h3>
          </div>
          <AiOutlineEdit
            className="EditInfoButton"
            id="EditInfoButton"
            onClick={toEditProfile}
          />
        </div>
      </div>
      <div className="ViewSections">
        <div className="sectionButtons" onClick={() => setMode("All")}>
          <h3>All</h3>
        </div>
        <div className="sectionButtons" onClick={() => setMode("Recommended")}>
          <h3>Recommended</h3>
        </div>
        <div className="sectionButtons" onClick={() => setMode("TopItems")}>
          <h3>Top selling</h3>
        </div>
        <div className="sectionButtons" onClick={() => setMode("Specials")}>
          <h3>Specials</h3>
        </div>
      </div>
      <div className="shoppableItems">
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
                  product_unit={item.unitShort}
                  product_brandID={item.brandID}
                  product_description={item.itemDescription}
                  user_id={state.userID}
                />
              );
            } else {
              if (item.categoryName == currcategoryFilter) {
                return (
                  <ShoppableCard
                    product_title={item.itemName}
                    product_ID={item.itemID}
                    product_imageurl={item.itemImageURL}
                    product_price={item.itemPrice}
                    product_mass={item.itemMass}
                    product_unit={item.unitShort}
                    product_brandID={item.brandID}
                    product_description={item.itemDescription}
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
