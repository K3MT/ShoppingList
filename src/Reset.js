import React, { useState } from "react";
import "./Reset.css";
import axios from "axios"
import { useNavigate } from "react-router-dom";
export default function Reset(props) {
  let timeout;

  const navigate = useNavigate();

  let strengthBadge;

  let password;

  let securityQuestion;

  let userEmailvalue;

  let userIDvalue;

  let answer;

  // The strong and weak password Regex pattern checker

  let strongPassword = new RegExp(
    "(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})"
  );
  let mediumPassword = new RegExp(
    "((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))"
  );

  //Function shows the password strength badge.
  function setPasswordStrength() {
    password = document.getElementById("resetsecuritypassword");
    strengthBadge = document.getElementById("StrengthDisp");
    password.addEventListener("input", () => {
      strengthBadge.style.display = "block";
      clearTimeout(timeout);

      //We then call the StrengChecker function as a callback then pass the typed password to it

      timeout = setTimeout(() => StrengthChecker(password.value), 500);

      //Incase a user clears the text, the badge is hidden again

      if (password.value.length !== 0) {
        strengthBadge.style.display = "block";
      } else {
        strengthBadge.style.display = "none";
      }
    });
  }

  //Function sets the color of the badge and the text content of the badge.
  function StrengthChecker(PasswordParameter) {
    // We then change the badge's color and text based on the password strength

    if (strongPassword.test(PasswordParameter)) {
      strengthBadge.style.backgroundColor = "green";
      strengthBadge.textContent = "Strong";
    } else if (mediumPassword.test(PasswordParameter)) {
      strengthBadge.style.backgroundColor = "blue";
      strengthBadge.textContent = "Medium";
    } else {
      strengthBadge.style.backgroundColor = "red";
      strengthBadge.textContent = "Weak";
    }
  }

  var notification = document.querySelector(".notification");

  // function called when the button to dismiss the message is clicked
  function dismissMessage() {
    // remove the .received class from the .notification widget
    notification = document.querySelector(".notification");
    notification.classList.remove("received");

    // call the generateMessage function to show another message after a brief delay
  }

  // function showing the message
  function showMessage() {
    // add a class of .received to the .notification container
    notification = document.querySelector(".notification");
    notification.classList.add("received");

    // attach an event listener on the button to dismiss the message
    // include the once flag to have the button register the click only one time
    const button = document.querySelector(".notification__message button");
    button.addEventListener("click", dismissMessage);
  }

  // function generating a message with a random title and text
  const generateMessage = (errortext) => {
    // after an arbitrary and brief delay create the message and call the function to show the element
    const title = "Error";
    const text = errortext;
    const message = document.querySelector(".notification__message");
    message.querySelector("h1").textContent = title;
    message.querySelector("p").textContent = text;
    message.className = `notification__message message--${title}`;
    showMessage();
  };

  //useState to check if user email is varified, if it is not do not proceed to reset page prompt page.
  const [isVerified, setisVarified] = useState(false);
  const [Data, setData] = useState({
    userID: "",
    securityQuestion: ""
  });

  //Fucntion to check the form validity in the isnotVarified state page.
  const checkFormValidity = () => {
    let email = document.getElementById("resetemail").value;
    if (email.length == 0) {
      generateMessage("You have not entered your email");
    } else {
      //request to check if email exists. If it does return security question, store it in security question. Store usermail in user email.
      submitForm();
    }
  };

  const setQuestion =()=>{
    console.log(securityQuestion);
    document.getElementById("resetsecurityquestion").placeholder = securityQuestion;
  }

  //Check the form validity of the input form in the isVarified state page.
  const checkFormValidity2 = () => {
    answer = document.getElementById("resetsecurityanswer").value;
    password = document.getElementById("resetsecuritypassword").value;
    if (answer.length == 0 || password.length == 0) {
      generateMessage("You have not entered your answer or new password");
    } else {
      //request to check if email exists. If it does return security question, store it in security question.
      if (strengthBadge.textContent == "Strong") {
        //do request
        submitForm2();
      } else {
        generateMessage("Password is too weak");
      }
    }
  };

  const submitForm = () => {
    const data = {
      userEmail: document.getElementById("resetemail").value,
    };
    console.log(data);
    axios
      .post("https://k3mt-backend.herokuapp.com/src/GetSecurityQuestion.php", {
        "data": data,
      })
      .then((result) => {
        console.log(result.data);
        if (result.data.length === 0) {
          generateMessage("Email not associated with any account");
        } else {
          userEmailvalue = document.getElementById("resetemail").value;
          // userIDvalue = result.data[0].userID;
          Data.userID = result.data[0].userID;
          Data.securityQuestion = result.data[0].securityQuestion;
          // securityQuestion = result.data[0].securityQuestion;
          setisVarified(true);
        }
      });
  };

  const submitForm2 = () => {
    const data = {
      userID: Data.userID,
      securityAnswer: answer,
      newPassword: password,
    };
    axios
      .post("https://k3mt-backend.herokuapp.com/src/ResetPassword.php", {
        "data": data,
      })
      .then((result) => {
        console.log(result.data);
        if (result.data.length === 0) {
          generateMessage("Reset unsuccesful");
        } else {
          navigate("/login");
        }
      });
  };

  if (isVerified) {
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
        <div class="notification">
          <div class="notification__message message--info">
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
        <div class="imessage_reset">
          <p class="from-me">
            Enter your security question answer and new password
          </p>
          <p class="from-me">If correct, your password will be reset</p>
        </div>

        <form className="Auth-form">
          <div className="Auth-form-content">
            <h3 className="Auth-form-title">Reset Password</h3>
            <div className="form-group mt-3">
              <label>Security Question</label>
              <input
                type="text"
                id="resetsecurityquestion"
                className="form-control mt-1"
                value={Data.securityQuestion}
              />
            </div>
            <div className="form-group mt-3">
              <label>Answer</label>
              <input
                type="text"
                className="form-control mt-1"
                placeholder="Enter your security question answer"
                id="resetsecurityanswer"
              />
            </div>
            <div className="form-group mt-3">
              <label>New password</label>
              <input
                type="password"
                className="form-control mt-1"
                placeholder="Enter your new password"
                onInput={setPasswordStrength}
                id="resetsecuritypassword"
              />
            </div>
            <span id="StrengthDisp" class="badge displayBadge">
              Weak
            </span>
            <div className="d-grid gap-2 mt-3">
              <button
                type="button"
                onClick={checkFormValidity2}
                className="btn btn-primary"
                onLoad={setQuestion}
              >
                Submit
              </button>
            </div>
          </div>
        </form>
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
        <div class="notification">
          <div class="notification__message message--info">
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
        <form className="Auth-form">
          <div className="Auth-form-content">
            <h3 className="Auth-form-title">Enter Email</h3>

            <div className="form-group mt-3">
              <label>Email</label>
              <input
                type="email"
                className="form-control mt-1"
                placeholder="Enter your email"
                id="resetemail"
              />
            </div>
            <div className="d-grid gap-2 mt-3">
              <button
                type="button"
                onClick={checkFormValidity}
                className="btn btn-primary"
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
