import React, { useState } from "react";
import "./Login.css";
import { useNavigate } from "react-router-dom";
import axios from "axios";
export default function Login(props) {
  //To navigate through different pages of teh website.
  const navigate = useNavigate();
  const loginToreset = () => {
    navigate("/reset");
  };

  const [Data, setData] = useState({ userEmail: "", userPassword: "" });

  const [userVerified, setuserVerified] = useState(false);

  // const handleChange = (e) => {
  //   setData({ ...Data, [e.target.name]: e.target.name });
  // };

  var loginnotification = document.querySelector(".loginnotification");

  // function called when the button to dismiss the message is clicked
  function dismissMessage() {
    // remove the .received class from the .loginnotification widget
    loginnotification = document.querySelector(".loginnotification");
    loginnotification.classList.remove("received");

    // call the generateMessage function to show another message after a brief delay
  }

  // function showing the message
  function showMessage() {
    // add a class of .received to the .loginnotification container
    loginnotification = document.querySelector(".loginnotification");
    loginnotification.classList.add("received");

    // attach an event listener on the button to dismiss the message
    // include the once flag to have the button register the click only one time
    const button = document.querySelector(".loginnotification__message button");
    button.addEventListener("click", dismissMessage);
  }

  // function generating a message with a random title and text
  const generateMessage = (errortext) => {
    // after an arbitrary and brief delay create the message and call the function to show the element
    const title = "Error";
    const text = errortext;
    const message = document.querySelector(".loginnotification__message");
    message.querySelector("h1").textContent = title;
    message.querySelector("p").textContent = text;
    message.className = `loginnotification__message message--${title}`;
    showMessage();
  };

  //Check if the input form is valid.
  const checkFormValidity = () => {
    let email = document.getElementById("loginemail").value;
    let password = document.getElementById("loginemail").value;
    if (email.length == 0 || password.length == 0) {
      generateMessage("You have not entered your email or password");
    } else {
      submitForm();
    }
  };

  const submitForm = () => {
    console.log("hahaha");
    const data = {
      userEmail: document.getElementById("loginemail").value,
      userPassword: document.getElementById("loginpassword").value,
    };
    console.log(data);
    axios
      .post("https://k3mt-shopping-list-backend.herokuapp.com/src/login.php", {
        "data": data,
      })
      .then((result) => {
        console.log(result.data);
        if (result.data.length === 0) {
          generateMessage("User does not exist");
        } else {
          navigate("/home");
        }
      });
  };

  if(userVerified){
    return(
      <div>
        <span>USER LOGGED IN</span>
      </div>
    );
  }
  else{
    return (
      <div className="Auth-form-container">
        <div class="loginarea">
          <ul class="logincircles">
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
  
        <div class="loginnotification">
          <div class="loginnotification__message message--info">
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
  
        <form className="Auth-form" onSubmit={submitForm}>
          <div className="Auth-form-content">
            <h3 className="Auth-form-title">Login</h3>
  
            <div className="form-group mt-3">
              <label>Email address</label>
              <input
                type="email"
                className="form-control mt-1"
                placeholder="Enter email"
                id="loginemail"
              />
            </div>
            <div className="form-group mt-3">
              <label>Password</label>
              <input
                type="password"
                className="form-control mt-1"
                placeholder="Enter password"
                name="userPassword"
                id="loginpassword"
              />
            </div>
            <a href="javascript:;" onClick={loginToreset}>
              Forgot password?
            </a>
            <div className="d-grid gap-2 mt-3">
              <button
                type="button"
                className="btn btn-primary"
                onClick={checkFormValidity}
              >
                Submit
              </button>
            </div>
          </div>
        </form>
      </div>
    );
  }
}
