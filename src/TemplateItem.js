import React from "react";
import { useEffect, useState } from "react";
import "./TemplateItem.css";
import { useHistory } from "react-router-dom";
import axios from "axios";

//TODO smooth out hover animation using css

function TemplateItem({
  stateChanger,
  title,
  keyy,
  imageurl,
  game_id,
  arbTourney,
  setArbtourney,
  tournament_id,
  item_id,
  user_id,
}) {
  useEffect(() => {
    window.scroll(0, 0);
  }, []);

  function removeFromTemplate() {
    console.log(document.getElementById("prodTitle").textContent);
    console.log(user_id);
    console.log(item_id);
    const data = {
      userID: user_id,
      itemID: item_id,
      typeTemplate: "true",
      typeCart: "false",
      typePublic: "false",
    };
    axios
      .post("https://k3mt-backend.herokuapp.com//src/RemoveItemFromList.php", {
        data: data,
      })
      .then((result) => {
        console.log(result.data);
        stateChanger(100 * game_id);
      });
  }

  return (
    <div className="templategameTile">
      <h3 id="prodTitle" className="Title">
        {title}
      </h3>
      <h3 className="Title">Price: R{game_id}</h3>
      <button className="addButtontemplate" onClick={removeFromTemplate}>
        Remove Item
      </button>
    </div>
  );
}
export default TemplateItem;
