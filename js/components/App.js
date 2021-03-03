import React from "react";
import 'bootstrap/dist/css/bootstrap.css';
import ReactDOM from 'react-dom'
import { ContextProviderGategorie } from '../Context/ContextCategorie';
import { BrowserRouter as Router, Route } from "react-router-dom";
import Add from "./Add";
import Edit from "./Edit";
import List from './List';
import ListGroup from 'react-bootstrap/ListGroup'



function App() {
    return ( <
        ContextProviderGategorie >

        <
        Router >

        <
        div >
        <
        div >
        <
        Route exact path = "/categorie" >
        <
        List / >




        <
        /Route> <
        Route path = "/add" >
        <
        Add / >
        <
        /Route>  <
        Route path = "/edit/:id"
        component = { Edit }
        />



        <
        /
        div >



        <
        /
        div > < /Router> < /
        ContextProviderGategorie >
    );
}


export default App;

if (document.getElementById('app')) {
    ReactDOM.render( < App / > , document.getElementById('app'));
}