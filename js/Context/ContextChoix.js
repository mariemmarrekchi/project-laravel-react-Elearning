import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const ChoixContext = createContext({});
export const ContextProviderChoix = ({ children }) => {

    const [choix, setChoix] = useState([]);


    useEffect(() => {
        listChoix();

    }, [])

    const addNewChoix = async(id_utlisateur, id_reponse) => {


        const choixObject = {
            id_utlisateur: id_utlisateur,
            id_reponse: id_reponse,

        };

        await axios.post('api/choix', choixObject)
            .then(res => console.log(res.data));

    };

    const listChoix = async() => {

        await axios.get('http://127.0.0.1:8000/api/choix')
            .then(res => {
                setChoix(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOneChoix = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/choix/${id}`)
            .then((res) => {
                console.log(res);
                // setChoix(res);
                console.log('choix successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listChoix();
    }

    const updateChoix = async(id, id_utlisateur, id_reponse) => {
        const choixObject = {
            id: id,
            id_utlisateur: id_utlisateur,
            id_reponse: id_reponse,


        };
        await axios.put('api/choix/' + id, choixObject)
            .then((res) => {
                console.log(res.data)
                console.log('choix successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const choixContext = {
        addNewChoix,
        listChoix,
        choix,
        deleteOneChoix,
        updateChoix
    };

    // pass the value in provider and return
    return <ChoixContext.Provider value = { choixContext } > { children } < /ChoixContext.Provider>;
};