import React, { useState } from "react"
import './Reset.css'
export default function Reset(props){
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
        <div class="imessage_reset">
            <p class="from-me">Enter your security question answer and new password</p>
            <p class="from-me">If correct, your password will be reset</p>
          </div>
        
          <form className="Auth-form">
            <div className="Auth-form-content">
              <h3 className="Auth-form-title">Reset Password</h3>
              <div className="form-group mt-3">
                <label>Security Question</label>
                <input
                  type="email"
                  className="form-control mt-1"
                  placeholder="<DELAY>"
                />
              </div>
              <div className="form-group mt-3">
                <label>Answer</label>
                <input
                  type="text"
                  className="form-control mt-1"
                  placeholder="Enter your security question answer"
                />
              </div>
              <div className="form-group mt-3">
                <label>New password</label>
                <input
                  type="password"
                  className="form-control mt-1"
                  placeholder="Enter your new password"
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