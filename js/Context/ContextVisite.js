import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const VisiteContext = createContext({});
export const ContextProviderVisite = ({ children }) => {

    const [visites, setVisite] = useState([]);


    useEffect(() => {
        listVisite();

    }, [])

    const addNewVisite = async(date, id_publication, id_utilisateur) => {


        const visiteObject = {
            date: date,
            id_publication: id_publication,
            id_utilisateur: id_utilisateur,

        };

        await axios.post('api/visite', visiteObject)
            .then(res => console.log(res.data));

    };

    const listVisite = async() => {

        await axios.get('http://127.0.0.1:8000/api/visite')
            .then(res => {
                setVisite(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOneVisite = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/visite/${id}`)
            .then((res) => {
                console.log(res);
                // setVisite(res);
                console.log('visite successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listVisite();
    }

    const updateVisite = async(id, date, id_publication, id_utilisateur) => {
        const visiteObject = {
            id: id,
            date: date,
            id_publication: id_publication,
            id_utilisateur: id_utilisateur

        };
        await axios.put('api/visite/' + id, visiteObject)
            .then((res) => {
                console.log(res.data)
                console.log('visite successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const visiteContext = {
        addNewVisite,
        listVisite,
        visites,
        deleteOneVisite,
        updateVisite
    };

    // pass the value in provider and return
    return <VisiteContext.Provider value = { visiteContext } > { children } < /VisiteContext.Provider>;
};