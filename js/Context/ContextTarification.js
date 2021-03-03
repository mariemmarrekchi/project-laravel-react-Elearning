import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const TarificationContext = createContext({});
export const ContextProviderTarification = ({ children }) => {

    const [tarifications, setTarification] = useState([]);


    useEffect(() => {
        listTarification();

    }, [])

    const addNewTarification = async(titre, description, prix) => {


        const tarificationObject = {
            titre: titre,
            description: description,
            prix: prix,
        };

        await axios.post('api/tarification', tarificationObject)
            .then(res => console.log(res.data));

    };

    const listTarification = async() => {

        await axios.get('http://127.0.0.1:8000/api/tarification')
            .then(res => {
                setTarification(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOneTarification = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/tarification/${id}`)
            .then((res) => {
                console.log(res);
                // setTarification(res);
                console.log('tarification successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listTarification();
    }

    const updateTarification = async(id, titre, description, prix) => {
        const tarificationObject = {
            id: id,
            titre: titre,
            description: description,
            prix: prix,
        };
        await axios.put('api/tarification/' + id, tarificationObject)
            .then((res) => {
                console.log(res.data)
                console.log('tarification successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const tarificationContext = {
        addNewTarification,
        listTarification,
        tarifications,
        deleteOneTarification,
        updateTarification
    };

    // pass the value in provider and return
    return <TarificationContext.Provider value = { tarificationContext } > { children } < /TarificationContext.Provider>;
};