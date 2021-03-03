import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const ReponseContext = createContext({});
export const ContextProviderReponse = ({ children }) => {
    const [reponses, setReponse] = useState([]);


    useEffect(() => {
        listReponse();

    }, [])

    const addNewReponse = async(text, etat, id_question) => {


        const reponseObject = {
            text: text,
            etat: etat,
            nature: nature,
            id_question: id_question


        };

        await axios.post('api/reponse', reponseObject)
            .then(res => console.log(res.data));

    };

    const listReponse = async() => {

        await axios.get('http://127.0.0.1:8000/api/reponse')
            .then(res => {
                setReponse(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOneReponse = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/reponse/${id}`)
            .then((res) => {
                console.log(res);
                // setReponse(res);
                console.log('Reponse successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listReponse();
    }

    const updateReponse = async(id, text, etat, id_question) => {
        const reponseObject = {
            id: id,
            text: text,
            etat: etat,
            id_question: id_question,

        };
        await axios.put('api/reponse/' + id, reponseObject)
            .then((res) => {
                console.log(res.data)
                console.log('Reponse successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const reponseContext = {
        addNewReponse,
        listReponse,
        reponses,
        deleteOneReponse,
        updateReponse
    };

    // pass the value in provider and return
    return <ReponseContext.Provider value = { reponseContext } > { children } < /ReponseContext.Provider>;
};