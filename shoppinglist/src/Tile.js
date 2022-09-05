import React from 'react';
import { useEffect, useState } from "react";
import './Tile.css';
import { useHistory } from 'react-router-dom';


//TODO smooth out hover animation using css

function Tile({ title, key, imageurl, game_id, arbTourney, setArbtourney, tournament_id }) {

    useEffect(() => {
        window.scroll(0, 0)
    }, [])

    return (
        <div className='gameTile'>
            <h3 className="Title">{title}</h3>
            <h3 className="Title">R{game_id}</h3>
            <div
                className="imageholder"
                
                style={{ width: '20em', height: '15em', backgroundSize: 'cover', borderRadius: '1em', backgroundImage: `url(${imageurl})` }}>
                
            </div>
        </div >
    );
}
export default Tile;