import React, { useState } from "react"
import './TFA.css'

export default function TFA(props){

    return (
        <div className="Auth-form-container">
          
          <div class="area" >
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
        </div >
        
          <form className="Auth-form">
            <div className="Auth-form-content">
              <h3 className="Auth-form-title">Enter the code that was sent to your email</h3>
              <div className="form-group mt-3">
                <label>Authentication code</label>
                <input
                  type="password"
                  className="form-control mt-1"
                  placeholder="Enter code"
                />
              </div>
              <div className="d-grid gap-2 mt-3">
                <button type="submit" className="btn btn-primary">
                  Submit
                </button>
              </div>
              
            </div>
          </form>
          
        </div>
      )
}