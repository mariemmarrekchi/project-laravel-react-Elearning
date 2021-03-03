import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const CommentaireContext = createContext({});
export const ContextProviderCommentaire = ({ children }) => {

    const [commentaires, setCommentaire] = useState([]);


    useEffect(() => {
        listCommentaire();

    }, [])

    const addNewCommentaire = async(text, date, id_publication, id_utilisateur) => {


        const commentaireObject = {
            text: text,
            date: date,
            id_publication: id_publication,
            id_utilisateur: id_utilisateur,


        };

        await axios.post('api/commentaire', commentaireObject)
            .then(res => console.log(res.data));

    };

    const listCommentaire = async() => {

        await axios.get('http://127.0.0.1:8000/api/commentaire')
            .then(res => {
                setCommentaire(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOneCommentaire = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/commentaire/${id}`)
            .then((res) => {
                console.log(res);
                // setCommentaire(res);
                console.log('Commentaire successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listCommentaire();
    }

    const updateCommentaire = async(id, text, date, id_publication, id_utilisateur) => {
        const commentaireObject = {
            id: id,
            text: text,
            date,
            date,
            id_publication: id_publication,
            id_utilisateur: id_utilisateur,



        };
        await axios.put('api/commentaire/' + id, commentaireObject)
            .then((res) => {
                console.log(res.data)
                console.log('Commentaire successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const commentaireContext = {
        addNewCommentaire,
        listCommentaire,
        commentaires,
        deleteOneCommentaire,
        updateCommentaire
    };

    // pass the value in provider and return
    return <CommentaireContext.Provider value = { commentaireContext } > { children } < /CommentaireContext.Provider>;
};