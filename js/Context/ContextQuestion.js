import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const QuestionContext = createContext({});
export const ContextProviderQuestion = ({ children }) => {
    const [questions, setQuestion] = useState([]);


    useEffect(() => {
        listQuestion();

    }, [])

    const addNewQuestion = async(titre, description, etat, type, id_questionnaire) => {


        const questionObject = {
            titre: titre,
            description: description,
            etat: etat,
            type: type,
            id_questionnaire: id_questionnaire,



        };

        await axios.post('api/question', questionObject)
            .then(res => console.log(res.data));

    };

    const listQuestion = async() => {

        await axios.get('http://127.0.0.1:8000/api/question')
            .then(res => {
                setQuestion(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOneQuestion = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/question/${id}`)
            .then((res) => {
                console.log(res);
                // setQuestion(res);
                console.log('Question successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listQuestion();
    }

    const updateQuestion = async(id, titre, description, etat, type, id_questionnaire) => {
        const questionObject = {
            id: id,
            titre: titre,
            description: description,
            etat: etat,
            type: type,
            id_questionnaire: id_questionnaire,


        };
        await axios.put('api/question/' + id, questionObject)
            .then((res) => {
                console.log(res.data)
                console.log('Question successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const questionContext = {
        addNewQuestion,
        listQuestion,
        questions,
        deleteOneQuestion,
        updateQuestion
    };

    // pass the value in provider and return
    return <QuestionContext.Provider value = { questionContext } > { children } < /QuestionContext.Provider>;
};