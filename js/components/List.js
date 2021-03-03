import React, { useEffect, useContext, useState } from "react";
import { Link } from 'react-router-dom';
import { GategorieContext } from '../Context/ContextCategorie';
import { Button } from 'react-bootstrap';
import Modal from 'react-bootstrap/Modal'
import { useHistory } from 'react-router-dom';

const List = () => {
    const history = useHistory();
    const [show, setShow] = useState(false);
    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);
    const { categories, listGategorie, deleteOneGategorie } = useContext(GategorieContext);
    const [data, setData] = useState([]);
    const [info, setInfo] = useState([]);
    useEffect(() => {
        listGategorie();
        setData(categories);
    }, [categories]);



    return ( <
        div >
        <
        h1 className = "text-center" > Liste Catégorie < /h1>  



        <
        div className = " container col-sm-9" >
        <
        Link to = "/add" > <
        button className = "btn btn-success" > to Add < /button> < /
        Link >

        <
        ul className = "list-group " > {
            data.map((result) => {
                return (

                    <
                    li key = { result.id }
                    className = "list-group-item" >

                    { result.titre } { result.description } { result.id_categorie } < img src = "public/images/img/{result.image}" / > <
                    button onClick = {
                        () => {

                            deleteOneGategorie(result.id);
                            history.push('/categorie');



                        }
                    }
                    className = "btn btn-danger" >
                    supprimer < /button>   <
                    Link className = "col-sm-2 btn btn-warning"
                    to = { "/edit/" + result.id } >
                    Edit <
                    /Link> 


                    <
                    Button variant = "primary"
                    onClick = {
                        () => {
                            handleShow();
                            setInfo(result);

                            console.log(result)
                        }
                    } >
                    View Detail <
                    /Button> <
                    Modal show = { show }
                    onHide = { handleClose } >
                    <
                    Modal.Header closeButton >
                    <
                    Modal.Title > < b className = "text-center text-primary" > Titre: < /b>{ info.titre } < /Modal.Title > < /
                    Modal.Header > <
                    Modal.Body > Detail: < div className = "text-info" > Description: < b > { info.description } < /b> </div >
                    <
                    div className = "text-info" > Id_categorie: < b > { info.id_categorie } < /b></div > < /Modal.Body>  <
                    Modal.Footer >
                    <
                    Button variant = "secondary"
                    onClick = {


                        handleClose

                    } >
                    close <
                    /Button> <
                    Button variant = "primary"
                    onClick = { handleClose } >
                    Save Changes <
                    /Button> < /
                    Modal.Footer > <
                    /Modal>


                    <
                    /
                    li >
                )
            })
        } <
        /ul>





        <
        /div> < /
        div >

    );

}

export default List;