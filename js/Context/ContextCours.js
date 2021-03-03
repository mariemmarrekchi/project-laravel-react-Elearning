import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const CoursContext = createContext({});
export const ContextProviderCours = ({ children }) => {

    const [cours, setCours] = useState([]);


    useEffect(() => {
        listCours();

    }, [])

    const addNewCours = async(titre, image, couverture, media, description, etat, nature, id_categorie, id_utilisateur) => {


        const CoursObject = {
            titre: titre,
            image: image,
            couverture: couverture,
            media: media,
            description: description,
            etat: etat,
            nature: nature,
            id_categorie: id_categorie,
            id_utilisateur: id_utilisateur


        };

        await axios.post('api/cours', CoursObject)
            .then(res => console.log(res.data));

    };

    const listCours = async() => {

        await axios.get('http://127.0.0.1:8000/api/cours')
            .then(res => {
                setCours(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOneCours = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/cours/${id}`)
            .then((res) => {
                console.log(res);
                // setCours(res);
                console.log('Cours successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listCours();
    }

    const updateCours = async(id, titre, image, couverture, media, description, etat, nature, id_categorie, id_utilisateur) => {
        const coursObject = {
            id: id,
            titre: titre,
            image: image,
            couverture: couverture,
            media: media,
            description: description,
            etat: etat,
            nature: nature,
            id_categorie: id_categorie,
            id_utilisateur: id_utilisateur

        };
        await axios.put('api/cours/' + id, coursObject)
            .then((res) => {
                console.log(res.data)
                console.log('Cours successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const coursContext = {
        addNewCours,
        listCours,
        cours,
        deleteOneCours,
        updateCours
    };

    // pass the value in provider and return
    return <CoursContext.Provider value = { coursContext } > { children } < /CoursContext.Provider>;
};