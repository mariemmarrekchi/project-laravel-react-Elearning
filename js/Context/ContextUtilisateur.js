import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const UtilisateurContext = createContext({});
export const ContextProviderUtilisateur = ({ children }) => {

    const [utilisateurs, setUtilisateur] = useState([]);


    useEffect(() => {
        listUtilisateur();

    }, [])

    const addNewUtilisateur = async(nom, prenom, password, token, expire_at, etat, id_compte) => {


        const utilisateurObject = {
            nom: nom,
            prenom: prenom,
            password: password,
            token: token,
            expire_at: expire_at,
            etat: etat,
            id_compte: id_compte
        };

        await axios.post('api/utilisateur', utilisateurObject)
            .then(res => console.log(res.data));

    };

    const listUtilisateur = async() => {

        await axios.get('http://127.0.0.1:8000/api/utilisateur')
            .then(res => {
                setUtilisateur(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOneUtilisateur = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/utilisateur/${id}`)
            .then((res) => {
                console.log(res);
                // setUtilisateur(res);
                console.log('utilisateur successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listUtilisateur();
    }

    const updateUtilisateur = async(id, nom, prenom, password, token, expire_at, etat, id_compte) => {
        const utilisateurObject = {
            id: id,
            nom: nom,
            prenom: prenom,
            password: password,
            token: token,
            expire_at: expire_at,
            etat: etat,
            id_compte: id_compte
        };
        await axios.put('api/utilisateur/' + id, utilisateurObject)
            .then((res) => {
                console.log(res.data)
                console.log('utilisateur successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const utilisateurContext = {
        addNewUtilisateur,
        listUtilisateur,
        utilisateurs,
        deleteOneUtilisateur,
        updateUtilisateur
    };

    // pass the value in provider and return
    return <UtilisateurContext.Provider value = { utilisateurContext } > { children } < /UtilisateurContext.Provider>;
};