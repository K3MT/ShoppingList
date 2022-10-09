import React, { useEffect, useState } from "react";
import { useLocation, useNavigate } from "react-router-dom";
import "./EditProfile.css";
import axios from "axios";

export default function EditProfile(props) {
  //Use location to get sent attributes
  const { state } = useLocation();
  let navigate = useNavigate();
  //Validate the form
  const validateForm = () => {
    if (document.getElementById("newbio").value.length != 0) {
      let data = {
        userID: state.userID,
        userAboutMe: document.getElementById("newbio").value,
      };
      axios
        .post(
          "https://k3mt-shopping-list-backend.herokuapp.com/src/UpdateAboutMe.php",
          {
            data: data,
          }
        )
        .then((result) => {
          if (result.data.length != 0) {
            let profilepicturelink =
              document.getElementById("newprofilepicture").value;
            let length =
              document.getElementById("newprofilepicture").value.length;
            console.log(length);
            if (length != 0) {
              console.log("Length achieved");
              if (1 == 1) {
                console.log("exists");
                let data_two = {
                  userID: state.userID,
                  userImageURL: profilepicturelink,
                };
                axios
                  .post(
                    "https://k3mt-shopping-list-backend.herokuapp.com/src/UploadProfilePicture.php",
                    {
                      data: data_two,
                    }
                  )
                  .then((result) => {
                    if (result.data.length != 0) {
                      navigate("/profile", { state: { userID: state.userID } });
                      console.log("done");
                    }
                  });
              } else {
                navigate("/profile", { state: { userID: state.userID } });
              }
            } else {
              navigate("/profile", { state: { userID: state.userID } });
            }
          }
        });
    }
  };

  //Check if the image url exists
  async function exists(url) {
    try {
      const result = await fetch(url, { method: "HEAD" });
      console.log(result.ok);
      if (result.ok) {
        console.log("exists!");
        return 1;
      } else {
        return 0;
      }
    } catch {
      return 0;
    }
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
          <h3 className="Auth-form-title">Update your bio</h3>

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
