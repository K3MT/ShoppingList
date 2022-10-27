import React, { useState, useEffect, useHistory } from "react";
import "./ListCreationInter.css";
import { useLocation, useNavigate } from "react-router-dom";
import axios from "axios";
import { Overlay } from "react-bootstrap";

export default function ListCreationInter(props) {
  //To navigate through different pages of teh website.
  const navigate = useNavigate();
  const { state } = useLocation();

  const [Data, setData] = useState({ listName: "", userID: state.userID });

  var listcreationinternotification = document.querySelector(
    ".listcreationinternotification"
  );

  // function called when the button to dismiss the message is clicked
  function dismissMessage() {
    // remove the .received class from the .listcreationinternotification widget
    listcreationinternotification = document.querySelector(
      ".listcreationinternotification"
    );
    listcreationinternotification.classList.remove("received");

    // call the generateMessage function to show another message after a brief delay
  }

  // function showing the message
  function showMessage() {
    // add a class of .received to the .listcreationinternotification container
    listcreationinternotification = document.querySelector(
      ".listcreationinternotification"
    );
    listcreationinternotification.classList.add("received");

    // attach an event listener on the button to dismiss the message
    // include the once flag to have the button register the click only one time
    const button = document.querySelector(
      ".listcreationinternotification__message button"
    );
    button.addEventListener("click", dismissMessage);
  }

  // function generating a message with a random title and text
  const generateMessage = (errortext) => {
    // after an arbitrary and brief delay create the message and call the function to show the element
    const title = "Error";
    const text = errortext;
    const message = document.querySelector(
      ".listcreationinternotification__message"
    );
    message.querySelector("h1").textContent = title;
    message.querySelector("p").textContent = text;
    message.className = `listcreationinternotification__message message--${title}`;
    showMessage();
  };

  //Check if the input form is valid.
  const checkFormValidity = () => {
    let listNameVar = document.getElementById("listName").value;
    if (listNameVar.length == 0) {
      generateMessage("You have not entered a name");
    } else {
      submitForm();
    }
  };

  const submitForm = () => {
    const data = {
      listName: document.getElementById("listName").value,
      userID: state.userID,
    };
    axios
      .post("https://k3mt-backend.herokuapp.com//src/CreateList.php", {
        data: data,
      })
      .then((result) => {
        console.log(result.data);
        if (result.data[0]["LIST_NAME_NOT_UNIQUE"]) {
          generateMessage("List name has been taken");
        }
        if (result.data[0]["INVALID_USER"]) {
          generateMessage("Invalid user");
        } else {
          navigate("/userlistcreation", {
            state: {
              listID: result.data[0].listID,
              listName: document.getElementById("listName").value,
              userID: state.userID,
              viewMode: "currentUser",
            },
          });
        }
      });
  };

  if (state.viewMode == "currentUser") {
  } else {
  }

  return (
    <div className="Auth-form-container-listcreationinter">
      <div class="listcreationinterarea">
        <ul class="listcreationintercircles">
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

      <div class="listcreationinternotification">
        <div class="listcreationinternotification__message message--info">
          <h1></h1>
          <p></p>
          <button aria-labelledby="button-dismiss">
            <span id="button-dismiss" hidden>
              Dismiss
            </span>
            <svg viewBox="0 0 100 100" width="10" height="10">
              <g
                stroke="currentColor"
                stroke-width="6"
                stroke-linecap="round"
                stroke-linejoin="round"
                fill="none"
              >
                <g transform="translate(50 50) rotate(45)">
                  <path d="M 0 -30 v 60 z M -30 0 h 60"></path>
                </g>
              </g>
            </svg>
          </button>
        </div>
      </div>

      <form className="Auth-form-listcreationinter" onSubmit={submitForm}>
        <div className="Auth-form-content-listcreationinter">
          <h3 className="Auth-form-title-listcreationinter">List Creation</h3>
          <div className="form-group mt-1">
            <label>List Name</label>
            <input
              type="text"
              className="form-control mt-4"
              placeholder="Enter list name"
              id="listName"
            />
          </div>
          <div className="d-grid gap-2 mt-3">
            <button
              type="button"
              className="btn-listcreationinter"
              onClick={checkFormValidity}
            >
              Create List
            </button>
          </div>
        </div>
      </form>
    </div>
  );
}
