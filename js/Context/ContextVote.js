import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const VoteContext = createContext({});
export const ContextProviderVote = ({ children }) => {

    const [votes, setVote] = useState([]);


    useEffect(() => {
        listVote();

    }, [])

    const addNewVote = async(nombre, id_utilisateur, id_cours) => {


        const voteObject = {
            nombre: nombre,
            id_utilisateur: id_utilisateur,
            id_cours: id_cours,

        };

        await axios.post('api/vote', voteObject)
            .then(res => console.log(res.data));

    };

    const listVote = async() => {

        await axios.get('http://127.0.0.1:8000/api/vote')
            .then(res => {
                set Vote(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOneVote = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/vote/${id}`)
            .then((res) => {
                console.log(res);
                // setVote(res);
                console.log('vote successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listVote();
    }

    const updateVote = async(id, nombre, id_utilisateur, id_cours) => {
        const voteObject = {
            id: id,
            nombre: nombre,
            id_utilisateur: id_utilisateur,
            id_cours: id_cours,

        };
        await axios.put('api/vote/' + id, voteObject)
            .then((res) => {
                console.log(res.data)
                console.log('vote successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const voteContext = {
        addNewVote,
        listVote,
        votes,
        deleteOneVote,
        updateVote
    };

    // pass the value in provider and return
    return <VoteContext.Provider value = { voteContext } > { children } < /VoteContext.Provider>;
};