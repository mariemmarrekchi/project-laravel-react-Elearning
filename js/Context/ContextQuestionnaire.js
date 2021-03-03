import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const QuestionnaireContext = createContext({});
export const ContextProviderQuestionnaire = ({ children }) => {
    const [questionnaires, setquestionnaire] = useState([]);


    useEffect(() => {
        listquestionnaire();

    }, [])

    const addNewquestionnaire = async(libelle, datedebut, datefin, description, type, etat, id_cours, id_utilisateur) => {


        const questionnaireObject = {
            libelle: libelle,
            datedebut: datedebut,
            datefin: datefin,
            description: description,
            type: type,
            etat: etat,
            id_cours: id_cours,
            id_utilisateur: id_utilisateur



        };

        await axios.post('api/questionnaire', questionnaireObject)
            .then(res => console.log(res.data));

    };

    const listquestionnaire = async() => {

        await axios.get('http://127.0.0.1:8000/api/questionnaire')
            .then(res => {
                setquestionnaire(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOnequestionnaire = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/questionnaire/${id}`)
            .then((res) => {
                console.log(res);
                // setquestionnaire(res);
                console.log('questionnaire successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listquestionnaire();
    }

    const updatequestionnaire = async(id, libelle, datedebut, datefin, description, type, etat, id_cours, id_utilisateur) => {
        const questionnaireObject = {
            id: id,
            libelle: libelle,
            datedebut: datedebut,
            datefin: datefin,
            description: description,
            type: type,
            etat: etat,
            id_cours: id_cours,
            id_utilisateur: id_utilisateur

        };
        await axios.put('api/questionnaire/' + id, questionnaireObject)
            .then((res) => {
                console.log(res.data)
                console.log('questionnaire successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const questionnaireContext = {
        addNewquestionnaire,
        listquestionnaire,
        questionnaires,
        deleteOnequestionnaire,
        updatequestionnaire
    };

    // pass the value in provider and return
    return <QuestionnaireaireContext.Provider value = { questionContext } > { children } < /QuestionnaireContext.Provider>;
};