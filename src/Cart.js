import React, { useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import "./Cart.css";
import CartItem from "./CartItem.js";
import TemplateItem from "./TemplateItem.js";
import axios from "axios";
export default function Cart(props) {
  const { state } = useLocation();
  const [listArray, setListArray] = useState([]);
  const [listArraytemplate, setListArraytemplate] = useState([]);
  const [stateChange, setstatechange] = useState(0);
  const [isResponse, setResponse] = useState(false);
  const [fectchedCartTotal, setfectchedCartTotal] = useState(false);
  const [cartTotal, setCartTotal] = useState(0);

  useEffect(() => {
    let mounted = true;
    let data = {
      userID: state.userID,
    };
    axios
      .post(
        "https://k3mt-shopping-list-backend.herokuapp.com/src/GetCartTotalPrice.php",
        {
          data: data,
        }
      )
      .then((result) => {
        setfectchedCartTotal(true);
        setCartTotal(result.data[0].totalCost);
      });
  }, [stateChange]);

  useEffect(() => {
    let mounted = true;
    let data = {
      userID: state.userID,
    };
    axios
      .post(
        "https://k3mt-shopping-list-backend.herokuapp.com/src/GetActiveCart.php",
        {
          data: data,
        }
      )
      .then((result) => {
        console.log(result.data);
        if (mounted) {
          setListArray(Array.from(result.data));
          setResponse(true);
        }
        return () => (mounted = false);
      });
  }, [stateChange]);

  useEffect(() => {
    let mounted = true;
    let data = {
      userID: state.userID,
    };
    axios
      .post("https://k3mt-backend.herokuapp.com//src/GetTemplateList.php", {
        data: data,
      })
      .then((result) => {
        console.log(result.data);
        if (mounted) {
          setListArraytemplate(Array.from(result.data));
          setResponse(true);
        }
        return () => (mounted = false);
      });
  }, [stateChange]);

  const checkOut = () => {
    let data = {
      userID: state.userID,
    };
    axios
      .post(
        "https://k3mt-shopping-list-backend.herokuapp.com/src/PurchaseCart.php",
        {
          data: data,
        }
      )
      .then((result) => {
        console.log(result.data);
        setstatechange(stateChange + 100);
      });
  };

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
      <div className="cartArea">
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
        <div className="cartInfo">
          <h1 className="cartTotalPrice">Total Price: R{cartTotal}</h1>
          <button className="CheckoutBtn" onClick={checkOut}>
            Checkout
          </button>
        </div>
        <div className="cartList">
          {isResponse &&
            listArray.map((item) => {
              return (
                <CartItem
                  stateChanger={setstatechange}
                  title={item.itemName}
                  keyy={item.count}
                  imageurl={item.itemImageURL}
                  game_id={item.itemPrice}
                  tournament_id={item.itemMass}
                  arbTourney={item.itemMass}
                  setArbtourney={item.brandID}
                  item_id={item.itemID}
                  user_id={state.userID}
                />
              );
            })}
        </div>
      </div>
      <div className="templateArea">
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
        <div className="cartInfo">
          <h1 className="cartTotalPrice">Template Items</h1>
        </div>
        <div className="templateList">
          {isResponse &&
            listArraytemplate.map((item) => {
              return (
                <TemplateItem
                  stateChanger={setstatechange}
                  title={item.itemName}
                  keyy={item.count}
                  imageurl={item.itemImageURL}
                  game_id={item.itemPrice}
                  tournament_id={item.itemMass}
                  arbTourney={item.itemMass}
                  setArbtourney={item.brandID}
                  item_id={item.itemID}
                  user_id={state.userID}
                />
              );
            })}
        </div>
      </div>
    </div>
  );
}
