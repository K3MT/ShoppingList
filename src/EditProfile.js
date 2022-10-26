import React, { useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import "./EditProfile.css";
import axios from "axios";

export default function EditProfile(props) {
  //Use location to get sent attributes
  const { state } = useLocation();
  let navigate = useNavigate();

  let userAboutMepassed;
  let userImageUrlpassed;

  var newAboutMe = state.userAboutMe;
  var newuserImageUrl = state.userImageURL;

  //Validate the form
  const validateForm = () => {
    newAboutMe = document.getElementById("newbio").value;

    if (document.getElementById("newbio").value.length == 0) {
      newAboutMe = state.userAboutMe;
    }
    newuserImageUrl = document.getElementById("newprofilepicture").value;
    if (document.getElementById("newprofilepicture").value.length == 0) {
      newuserImageUrl = state.userImageURL;
    }

    let data = {
      userID: state.userID,
      userAboutMe: newAboutMe,
    };

    userAboutMepassed = true;
    userImageUrlpassed = true;

    axios
      .post("https://k3mt-backend.herokuapp.com//src/UpdateAboutMe.php", {
        data: data,
      })
      .then((result) => {
        if (result.data[0].length == 1) {
          userAboutMepassed = false;
        }
        var tester = new Image();
        tester.onload = imageFound;
        tester.onerror = imageNotFound;
        tester.src = newuserImageUrl;
      });
  };

  function imageFound() {
    let data_profilepicture = {
      userID: state.userID,
      userImageURL: newuserImageUrl,
    };
    axios
      .post(
        "https://k3mt-backend.herokuapp.com//src/UploadProfilePicture.php",
        {
          data: data_profilepicture,
        }
      )
      .then((result) => {
        if (result.data[0].length == 1) {
          userImageUrlpassed = false;
        }
        if (userAboutMepassed && userImageUrlpassed) {
          navigate("/profile", { state: { userID: state.userID } });
        }
      });
  }

  function imageNotFound() {
    alert("Image could not be found, Profile picture set to default");
    let data_profilepicture = {
      userID: state.userID,
      userImageURL: "https://i.imgur.com/CjnIMqJ.png",
    };
    axios
      .post(
        "https://k3mt-backend.herokuapp.com//src/UploadProfilePicture.php",
        {
          data: data_profilepicture,
        }
      )
      .then((result) => {
        if (result.data[0].length == 1) {
          userImageUrlpassed = false;
        }
        if (userAboutMepassed && userImageUrlpassed) {
          navigate("/profile", { state: { userID: state.userID } });
        }
      });
  }

  //Return the html
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

      <form className="Auth-form-edit">
        <div className="Auth-form-content">
          <h3 className="Auth-form-edit-title">Update your bio</h3>

          <div className="form-group mt-3">
            <label>New Bio</label>
            <input
              type="text"
              className="form-control mt-1"
              placeholder="Enter new bio"
              id="newbio"
            />
          </div>

          <div className="form-group mt-3">
            <label>Profile picture link</label>
            <input
              type="text"
              className="form-control mt-1"
              placeholder="Enter link to picture"
              id="newprofilepicture"
            />
          </div>
          <div className="editSubmitButton" onClick={validateForm}>
            <h3>Submit</h3>
          </div>
        </div>
      </form>
    </div>
  );
}
