import React, { useState, useContext, useEffect } from "react";
import { useHistory } from 'react-router-dom';
import { GategorieContext } from '../Context/ContextCategorie';

const Add = () => {
    const [titre, setTitre] = useState("t1");
    const [description, setDescription] = useState("");
    const [image, setImage] = useState("");
    const [id_categorie, setId_categorie] = useState(1);

    const history = useHistory();

    const { addNewGategorie, categories, listGategorie } = useContext(GategorieContext);

    const [data, setData] = useState([]);
    const [info, setInfo] = useState([]);
    useEffect(() => {
        listGategorie();
        setData(categories);
    }, [categories]);

    const handleSubmit = (event) => {
        event.preventDefault();
        addNewGategorie(titre, description, image, id_categorie);
        history.push("/categorie");
    }

    return ( <
        div className = "container text-center" >
        <
        form method = "POST"
        encType = "multipart/form-data"
        onSubmit = { handleSubmit } >
        <
        input type = "hidden"
        name = "csrf-token"
        value = "{{{ csrf_token() }}}" / >
        <
        h1 > New Categorie < /h1> <
        div className = "form-group" >
        <
        label className = "control-label" >
        titre:
        <
        input className = "form-control"
        name = "titre"
        type = "text"
        value = { titre }
        onChange = {
            (e) => setTitre(e.target.value)
        }
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

        type = "file"
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
        name = "id_categorie"
        onClick = {
            e => {
                setId_categorie(e.target.value);
                console.log(id_categorie)
            }
        } > {
            data.map((result) => {
                return ( <
                    option required key = { result.id }

                    value = { result.id } > { result.titre } < /option>
                )
            })

        } <
        /select> < /
        label > < /
        div >



        <
        button className = "btn btn-success" > Add < /button> < /
        form >

        <
        /div>

    );

}

export default Add;