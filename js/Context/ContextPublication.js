import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const PublicationContext = createContext({});
export const ContextProviderPublication = ({ children }) => {
    const [publications, setPublication] = useState([]);


    useEffect(() => {
        listPublication();

    }, [])

    const addNewPublication = async(titre, image, couverture, media, description, etat, nature, id_cours, id_utilisateur) => {


        const publicationObject = {
            titre: titre,
            image: image,
            couverture: couverture,
            media: media,
            description: description,
            etat: etat,
            nature: nature,
            id_cours: id_cours,
            id_utilisateur: id_utilisateur


        };

        await axios.post('api/publication', publicationObject)
            .then(res => console.log(res.data));

    };

    const listPublication = async() => {

        await axios.get('http://127.0.0.1:8000/api/publication')
            .then(res => {
                setPublication(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOnePublication = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/publication/${id}`)
            .then((res) => {
                console.log(res);
                // setPublication(res);
                console.log('Publication successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listPublication();
    }

    const updatePublication = async(id, titre, image, couverture, media, description, etat, nature, id_cours, id_utilisateur) => {
        const publicationObject = {
            id: id,
            titre: titre,
            image: image,
            couverture: couverture,
            media: media,
            description: description,
            etat: etat,
            nature: nature,
            id_cours: id_cours,
            id_utilisateur: id_utilisateur

        };
        await axios.put('api/publication/' + id, publicationObject)
            .then((res) => {
                console.log(res.data)
                console.log('Publication successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const publicationContext = {
        addNewPublication,
        listPublication,
        publications,
        deleteOnePublication,
        updatePublication
    };

    // pass the value in provider and return
    return <PublicationContext.Provider value = { publicationContext } > { children } < /PublicationContext.Provider>;
};