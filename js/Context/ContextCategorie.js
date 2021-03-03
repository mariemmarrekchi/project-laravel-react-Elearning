import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
import ServiceCategorie from '../services/ServiceCategorie';
export const GategorieContext = createContext({});
export const ContextProviderGategorie = ({ children }) => {

    const [categories, setGategorie] = useState([]);


    useEffect(() => {
        listGategorie();

    }, [])

    const addNewGategorie = async(titre, description, image, id_categorie) => {

        const categorieObject = {
            titre: titre,
            description: description,
            image: image,
            id_categorie: id_categorie
        };

        await axios.post('http://127.0.0.1:8000/api/categorie/api/categorie', categorieObject)
            .then(res => console.log(res.data));


    };

    const listGategorie = async() => {
        const res = await ServiceCategorie.listGategorie();
        setGategorie(res);


    }
    const deleteOneGategorie = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/categorie/${id}`)
            .then((res) => {
                console.log(res);
                // setGategorie(res);
                console.log('categorie successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            // ServiceCategorie.deleteOneGategorie(id);
    }

    const updateGategorie = async(id, titre, description, image, id_categorie) => {
        ServiceCategorie.updateGategorie(id, titre, description, image, id_categorie)

    }

    // Make the context object:
    const categorieContext = {
        addNewGategorie,
        listGategorie,
        categories,
        deleteOneGategorie,
        updateGategorie
    };

    // pass the value in provider and return
    return <GategorieContext.Provider value = { categorieContext } > { children } < /GategorieContext.Provider>;
};