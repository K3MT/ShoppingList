import React from "react";

const PopupNote = (open, title, price, mass) => {
  if (open) {
    return (
      <div className="overlay">
        <div className="modalContainer">
          <h3>{title}</h3>
          <h2>{price}</h2>
          <h2>{mass}</h2>
        </div>
      </div>
    );
  }
};
export default PopupNote;
