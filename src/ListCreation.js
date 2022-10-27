import React, { useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import "./ListCreation.css";
import AvailableListItem from "./AvailableListItem.js";
import UserListItem from "./UserListItem.js";
import OtherListItem from "./OtherListItem";
import axios from "axios";
export default function UserListCreation(props) {
  const { state } = useLocation();

  console.log(state.viewMode);
  const navigate = useNavigate();

  const [tempListItems, settempListItems] = useState([]);
  const [tempListStateChange, settempListStateChange] = useState(0);
  const [availableItemsFetched, setavailableItemsFetched] = useState(false);

  const [availableListItems, setavailableListItems] = useState([]);
  const [availableListStateChange, setavailableListStateChange] = useState(0);
  const [tempItemsFetched, settempItemsFetched] = useState(false);

  //Get all items you can pick from.
  useEffect(() => {
    let mounted = true;
    let data = {};
    let url = "https://k3mt-backend.herokuapp.com//src/GetAllItems.php";
    axios
      .post(url, {
        data: data,
      })
      .then((result) => {
        settempListItems(Array.from(result.data));
        setavailableItemsFetched(true);
      });
  }, [tempListStateChange]);

  //Get all items you can pick from.
  useEffect(() => {
    const data = {
      listID: state.listID,
    };
    let url = "https://k3mt-backend.herokuapp.com//src/GetListItems.php";
    axios
      .post(url, {
        data: data,
      })
      .then((result) => {
        console.log(result.data);
        setavailableListItems(Array.from(result.data));
        settempItemsFetched(true);
      });
  }, [tempListStateChange]);

  const tempListStateChanger = () => {
    settempListStateChange(tempListStateChange + 1);
  };

  const toProfileManagement = () => {
    navigate("/management", {
      state: {
        userID: state.userID,
      },
    });
  };

  const deleteList = () => {
    const data = {
      listID: state.listID,
    };
    let url = "https://k3mt-backend.herokuapp.com//src/DeleteList.php";
    axios
      .post(url, {
        data: data,
      })
      .then((result) => {
        navigate("/management", {
          state: {
            userID: state.userID,
          },
        });
      });
  };

  const addListToCart = () => {
    const data = {
      listID: state.listID,
      userID: state.userID,
    };
    let url = "https://k3mt-backend.herokuapp.com//src/AddListToCart.php";
    axios
      .post(url, {
        data: data,
      })
      .then((result) => {
        console.log(result.data);
        navigate("/management", {
          state: {
            userID: state.userID,
          },
        });
      });
  };

  if (state.viewMode == "currentUser") {
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
        <div className="listItemsArea">
          <div className="availableItemsHeader2">
            <h1 className="availableItemsH2">{state.listName}</h1>
          </div>
          <div className="endButtons">
            <div className="endButton" onClick={toProfileManagement}>
              Done
            </div>
            <div className="endButton" onClick={deleteList}>
              Delete List
            </div>
            <div className="endButton" onClick={addListToCart}>
              Add to Cart
            </div>
          </div>
          <div className="listItemsList">
            {tempItemsFetched &&
              availableListItems.map((item) => {
                return (
                  <UserListItem
                    stateChanger={tempListStateChanger}
                    list_ID={state.listID}
                    product_name={item.itemName}
                    product_price={item.itemPrice}
                    product_count={item.count}
                    product_imageurl={item.itemImageURL}
                    product_ID={item.itemID}
                    user_id={state.userID}
                  />
                );
              })}
          </div>
        </div>

        <div className="availableItemsArea">
          {/* <div class="area">
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
          </div> */}
          <div className="availableItemsHeader">
            <h1 className="availableItemsH1">Available Items</h1>
          </div>
          <div className="availableItemsList">
            {availableItemsFetched &&
              tempListItems.map((item) => {
                return (
                  <AvailableListItem
                    stateChanger={tempListStateChanger}
                    list_ID={state.listID}
                    product_name={item.itemName}
                    product_price={item.itemPrice}
                    product_imageurl={item.itemImageURL}
                    product_ID={item.itemID}
                    user_id={state.userID}
                  />
                );
              })}
          </div>
        </div>
      </div>
    );
  } else {
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
        <div className="otherlistItemsArea">
          <div className="otheravailableItemsHeader2">
            <h1 className="otheravailableItemsH2">{state.listName}</h1>
          </div>
          <div className="otherendButtons">
            <div className="otherendButton" onClick={toProfileManagement}>
              Done
            </div>
            <div className="otherendButton" onClick={addListToCart}>
              Add
            </div>
          </div>
          <div className="otherlistItemsList">
            {tempItemsFetched &&
              availableListItems.map((item) => {
                return (
                  <OtherListItem
                    product_name={item.itemName}
                    product_price={item.itemPrice}
                    product_imageurl={item.itemImageURL}
                    product_count={item.count}
                  />
                );
              })}
          </div>
        </div>
      </div>
    );
  }
}
