import React, { useState } from "react";
import "./Register.css";
import axios from "axios"
import { useNavigate } from "react-router-dom";

export default function Register(props) {
  const navigate = useNavigate();
  let timeout;

  //The variable for the password strength badge
  let strengthBadge;

  // The strong and weak password Regex pattern checker
  let password;

  //The regular expression to check the strngth of the entered passsword
  let strongPassword = new RegExp(
    "(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})"
  );
  let mediumPassword = new RegExp(
    "((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))"
  );

  //This function will be used to show the badge
  function setPasswordStrength() {
    password = document.getElementById("registerpassword");
    console.log("present");
    strengthBadge = document.getElementById("StrengthDisp");
    password.addEventListener("input", () => {
      //The badge is hidden by default, so we show it

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

  //This function is used to set the color of the password strength badge and the text content of the badge.
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
  }

  // function showing the message
  function showMessage() {
    // add a class of .received to the .notification container
    notification = document.querySelector(".notification");
    notification.classList.add("received");

    // attach an event listener on the button to dismiss the message
    // include the once flag to have the button register the click only one time
    const button = document.querySelector(
      ".notification__message button"
    );
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

  //Function to check if teh form is valid
  const checkFormValidity = () => {
    let email = document.getElementById("registeremail").value;
    let password = document.getElementById("registerpassword").value;
    let fname = document.getElementById("registerfname").value;
    let sname = document.getElementById("registersname").value;
    let question = document.getElementById("registersquestion").value;
    let answer = document.getElementById("registersanswer").value;
    if (
      email.length == 0 ||
      password.length == 0 ||
      fname.length == 0 ||
      sname.length == 0 ||
      question.length == 0 ||
      answer.length == 0
    ) {
      generateMessage("One of the input fields have not been filled");
    } else {
      if (strengthBadge.textContent == "Weak") {
        generateMessage("Password too weak");
      } else {
        submitForm();
      }
    }
  };

  const submitForm = () => {
    const data = {
      firstName: document.getElementById("registerfname").value,
      lastName: document.getElementById("registersname").value,
      userEmail: document.getElementById("registeremail").value,
      userPassword: document.getElementById("registerpassword").value,
      securityQuestion: document.getElementById("registersquestion").value,
      securityAnswer: document.getElementById("registersanswer").value,
    };
    console.log(data);
    axios
      .post("https://k3mt-shopping-list-backend.herokuapp.com/src/registration.php", {
        "data": data,
      })
      .then((result) => {
        console.log(result.data);
        if (result.data.length === 0) {
          generateMessage("User does not exist");
        } else {
          navigate("/login");
        }
      });
  };

  return (
    <div className="Auth-form-container">
      <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
        crossorigin="anonymous"
      ></link>
      <div class="registerarea">
        <ul class="registercircles">
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

      <div class="imessage_security">
        <p class="from-me">Enter a security question and answer</p>
        <p class="from-me">
          For example, the question might be your dog's name
        </p>
        <p class="from-me">
          This information will be used in the event that you forget your
          password
        </p>
        <p class="from-me">& you need to reset it</p>
      </div>
      <form className="Auth-form">
        <div className="Auth-form-content">
          <h3 className="Auth-form-title">Register</h3>

          <div className="form-group mt-3">
            <label>First Name</label>
            <input
              type="text"
              className="form-control mt-1"
              placeholder="e.g Jane Doe"
              autoComplete="false"
              id="registerfname"
            />
          </div>
          <div className="form-group mt-3">
            <label>Second Name</label>
            <input
              type="text"
              className="form-control mt-1"
              placeholder="e.g Jane Doe"
              autoComplete="false"
              id="registersname"
            />
          </div>
          <div className="form-group mt-3">
            <label>Email</label>
            <input
              type="email"
              className="form-control mt-1"
              placeholder="Email Address"
              autoComplete="false"
              id="registeremail"
            />
          </div>
          <div className="form-group mt-3">
            <label>Password</label>
            <input
              type="password"
              className="form-control mt-1"
              placeholder="Password"
              id="registerpassword"
              onInput={setPasswordStrength}
            />
          </div>
          <span id="StrengthDisp" class="badge displayBadge">
            Weak
          </span>
          <div className="form-group mt-3">
            <label>Security Question</label>
            <input
              type="text"
              className="form-control mt-1"
              placeholder="Security Question"
              id="registersquestion"
            />
          </div>
          <div className="form-group mt-3">
            <label>Answer</label>
            <input
              type="password"
              className="form-control mt-1"
              placeholder="Security Question Answer"
              id="registersanswer"
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
      <div class="imessage">
        <p class="from-me">Your password must be at least 8 characters long</p>
        <p class="from-me">It should have at least one uppercase letter</p>
        <p class="from-me">It should also have atleast one lowercase letter</p>
        <p class="from-me">It should also have at least one digit</p>
        <p class="from-me">
          It should also have at least one special character
        </p>
      </div>
    </div>
  );
}
