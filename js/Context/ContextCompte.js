import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const CompteContext = createContext({});
export const ContextProviderCompte = ({ children }) => {

    const [comptes, setCompte] = useState([]);


    useEffect(() => {
        listCompte();

    }, [])

    const addNewCompte = async(libelle, etat) => {


        const compteObject = {
            libelle: libelle,
            etat: etat,

        };

        await axios.post('api/compte', compteObject)
            .then(res => console.log(res.data));

    };

    const listCompte = async() => {

        await axios.get('http://127.0.0.1:8000/api/compte')
            .then(res => {
                setCompte(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOneCompte = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/compte/${id}`)
            .then((res) => {
                console.log(res);
                // setCompte(res);
                console.log('compte successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listCompte();
    }

    const updateCompte = async(id, libelle, etat) => {
        const compteObject = {
            id: id,
            libelle: libelle,
            etat: etat,

        };
        await axios.put('api/compte/' + id, compteObject)
            .then((res) => {
                console.log(res.data)
                console.log('compte successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const compteContext = {
        addNewCompte,
        listCompte,
        comptes,
        deleteOneCompte,
        updateCompte
    };

    // pass the value in provider and return
    return <CompteContext.Provider value = { compteContext } > { children } < /CompteContext.Provider>;
};