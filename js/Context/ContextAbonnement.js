import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const AbonnementContext = createContext({});
export const ContextProviderAbonnement = ({ children }) => {

    const [abonnements, setAbonnement] = useState([]);


    useEffect(() => {
        listAbonnement();

    }, [])

    const addNewAbonnement = async(prix, promo, type, nature, etat, id_utilisateur, id_tarification) => {


        const abonnementObject = {
            prix: prix,
            promo: promo,
            type: type,
            nature: nature,
            etat: etat,
            id_utilisateur: id_utilisateur,
            id_tarification: id_tarification
        };

        await axios.post('api/abonnement', abonnementObject)
            .then(res => console.log(res.data));

    };

    const listAbonnement = async() => {

        await axios.get('http://127.0.0.1:8000/api/abonnement')
            .then(res => {
                setAbonnement(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOneAbonnement = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/abonnement/${id}`)
            .then((res) => {
                console.log(res);
                // setAbonnement(res);
                console.log('abonnement successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listAbonnement();
    }

    const updateAbonnement = async(id, prix, promo, type, nature, etat, id_utilisateur, id_tarification) => {
        const abonnementObject = {
            id: id,
            prix: prix,
            promo: promo,
            type: type,
            nature: nature,
            etat: etat,
            id_utilisateur: id_utilisateur,
            id_tarification: id_tarification
        };
        await axios.put('api/abonnement/' + id, abonnementObject)
            .then((res) => {
                console.log(res.data)
                console.log('abonnement successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const abonnementContext = {
        addNewAbonnement,
        listAbonnement,
        abonnements,
        deleteOneAbonnement,
        updateAbonnement
    };

    // pass the value in provider and return
    return <AbonnementContext.Provider value = { abonnementContext } > { children } < /AbonnementContext.Provider>;
};