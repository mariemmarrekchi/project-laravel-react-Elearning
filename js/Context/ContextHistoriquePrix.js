import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const HistoriqueContext = createContext({});
export const ContextProviderHistorique = ({ children }) => {
    const [historiques, setHistorique] = useState([]);

    useEffect(() => {
        listHistorique();

    }, [])

    const addNewHistorique = async(datedebut, datefin, prix, id_cours) => {


        const historiqueObject = {
            datedebut: datedebut,
            datefin: datefin,
            prix: prix,
            id_cours: id_cours
        };

        await axios.post('api/histroiquePrix', historiqueObject)
            .then(res => console.log(res.data));

    };

    const listHistorique = async() => {

        await axios.get('http://127.0.0.1:8000/api/histroiquePrix')
            .then(res => {
                setHistorique(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOneHistorique = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/histroiquePrix/${id}`)
            .then((res) => {
                console.log(res);
                // setHistorique(res);
                console.log('historique successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listHistorique();
    }

    const updateHistorique = async(id, titre, description, image, id_historique) => {
        const historiqueObject = {
            id: id,
            titre: titre,
            description: description,
            image: image,
            id_historique: id_historique
        };
        await axios.put('api/histroiquePrix/' + id, historiqueObject)
            .then((res) => {
                console.log(res.data)
                console.log('historique successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const historiqueContext = {
        addNewHistorique,
        listHistorique,
        historiques,
        deleteOneHistorique,
        updateHistorique
    };

    // pass the value in provider and return
    return <HistoriqueContext.Provider value = { historiqueContext } > { children } < /HistoriqueContext.Provider>;
};