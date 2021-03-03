import React, { useEffect, useState, useContext } from "react";
import axios from 'axios';
import { GategorieContext } from '../Context/ContextCategorie';
import { useHistory } from "react-router-dom";

const Edit = ({ match }) => {

    const categoriecontext = useContext(GategorieContext);
    const {
        updateGategorie,
        listGategorie,
        categories
    } = categoriecontext;

    const id = match.params.id;

    const [titre, setTitre] = useState("");
    const [description, setDescription] = useState("");
    const [image, setImage] = useState("");
    const [id_categorie, setId_categorie] = useState(1);
    const history = useHistory();
    const [data, setData] = useState([]);
    // useEffect(() => {
    //     listGategorie();
    //     setData(categories);
    // }, [categories]);

    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/categorie/' + match.params.id)
            .then(res => {
                setTitre(res.data.titre);
                setDescription(res.data.description);
                setImage(res.data.image);
                setId_categorie(res.data.id_categorie);
            })
            .catch((error) => {
                console.log(error);
            })
    }, [])


    const handleSubmit = (event) => {
        event.preventDefault();
        updateGategorie
            (id, titre, description, image, id_categorie);

        history.push("/categorie");

    }

    return ( <
        div className = "container text-center" >

        <
        form onSubmit = { handleSubmit } >
        <
        h1 > Update Categorie < /h1> <
        div className = "form-group" >
        <
        label className = "control-label" >
        titre:
        <
        input className = "form-control"
        name = "titre"
        type = "text"
        value = { titre }
        onChange = { e => setTitre(e.target.value) }
        required / >
        <
        /label> < /
        div > <
        div className = "form-group" >
        <
        label className = "control-label" >
        description:
        <
        input className = "form-control"
        name = "description"
        type = "text"
        value = { description }
        onChange = { e => setDescription(e.target.value) }
        required / >
        <
        /label> < /
        div > <
        div className = "form-group" >
        <
        label className = "control-label" >
        image:
        <
        input className = "form-control"
        name = "image"
        type = "text"
        value = { image }
        onChange = { e => setImage(e.target.value) }
        required / >
        <
        /label> < /
        div >


        <
        div className = "form-group" >
        <
        label className = "control-label" >
        categorie:
        <
        select className = "form-control"


        onClick = {
            e => {
                setId_categorie(e.target.value)
                console.log(id_categorie);
                setData(categories)
            }
        }
        name = "id_categorie" >


        {
            data.map((result) => {
                return ( <
                    option required key = { result.id }

                    value = { result.id } > { result.titre } < /option>
                )
            })

        }

        <
        /
        select > < /
        label > < /
        div >


        <
        button className = "btn btn-success" > Update < /button> < /
        form >

        <
        /div>

    );

}

export default Edit;