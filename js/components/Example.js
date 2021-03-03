import React from "react";
import 'bootstrap/dist/css/bootstrap.css';
import ReactDOM from 'react-dom'
import { ContextProviderGategorie } from './Context';
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
import Add from "./Add";
import Edit from "./Edit";
import List from './List';


function Router() {
    return ( < Router >



        <
        div >

        <
        ContextProviderGategorie >



        {
            /* A <Switch> looks through its children <Route>s and
                          renders the first one that matches the current URL. */
        } <
        Switch >
        <
        Route path = "/add" >
        <
        Add / >
        <
        /Route> <
        Route path = "/edit" >
        <
        Edit / >
        <
        /Route> <
        Route path = "/" >
        <
        List / >
        <
        /Route> < /
        Switch > <
        /ContextProviderGategorie> < /
        div > <
        /Router>
    );
}


export default Router;

if (document.getElementById('example')) {
    ReactDOM.render( < Router / > , document.getElementById('example'));
}