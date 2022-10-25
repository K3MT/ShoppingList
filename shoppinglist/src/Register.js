import React, { useState } from "react";
import "./Register.css";

export default function Register(props) {
  let timeout;

  let strengthBadge;

  let password;
  // The strong and weak password Regex pattern checker

  let strongPassword = new RegExp(
    "(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})"
  );
  let mediumPassword = new RegExp(
    "((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))"
  );

  function setPasswordStrength() {
    password = document.getElementById("PassEntry");
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

  // Adding an input event listener when a user types to the  password input

  return (
    <div className="Auth-form-container">
      <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
        crossorigin="anonymous"
      ></link>
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
            />
          </div>
          <div className="form-group mt-3">
            <label>Second Name</label>
            <input
              type="text"
              className="form-control mt-1"
              placeholder="e.g Jane Doe"
              autoComplete="false"
            />
          </div>
          <div className="form-group mt-3">
            <label>Email</label>
            <input
              type="email"
              className="form-control mt-1"
              placeholder="Email Address"
              autoComplete="false"
            />
          </div>
          <div className="form-group mt-3">
            <label>Password</label>
            <input
              type="password"
              className="form-control mt-1"
              placeholder="Password"
              id="PassEntry"
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
            />
          </div>
          <div className="form-group mt-3">
            <label>Answer</label>
            <input
              type="password"
              className="form-control mt-1"
              placeholder="Security Question Answer"
            />
          </div>
          <div className="d-grid gap-2 mt-3">
            <button type="submit" className="btn btn-primary">
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
