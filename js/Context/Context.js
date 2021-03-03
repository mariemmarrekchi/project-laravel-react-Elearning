import React, { useEffect, createContext, useState } from 'react';
import axios from 'axios';
export const GategorieContext = createContext({});
export const ContextProviderGategorie = ({ children }) => {

    const [categories, setGategorie] = useState([]);


    useEffect(() => {
        listGategorie();

    }, [])

    const addNewGategorie = async(titre, description, image, id_categorie) => {


        const categorieObject = {
            titre: titre,
            description: description,
            image: image,
            id_categorie: id_categorie
        };

        await axios.post('api/categorie', categorieObject)
            .then(res => console.log(res.data));

    };

    const listGategorie = async() => {

        await axios.get('http://127.0.0.1:8000/api/categorie')
            .then(res => {
                setGategorie(res.data);
                return res.data;
            })
            .catch((error) => {
                console.log(error);
            })

    }
    const deleteOneGategorie = async(id) => {
        console.log(id);
        await axios.delete(`http://127.0.0.1:8000/api/categorie/${id}`)
            .then((res) => {
                console.log(res);
                // setGategorie(res);
                console.log('categorie successfully deleted!')
            }).catch((error) => {
                console.log(error)

            })
            //return listGategorie();
    }
    const deleteRow = (id, e) => {

        axios.delete(`http://127.0.0.1:8000/api/categorie/${id}`)

        .then(res => {

            console.log(res);

            console.log(res.data);



            const categorie = categories.filter(item => item.id !== id);

            this.setState({ categorie });

        })



    }
    const updateGategorie = async(id, titre, description, image, id_categorie) => {
        const studentObject = {
            id: id,
            titre: titre,
            description: description,
            image: image,
            id_categorie: id_categorie
        };
        await axios.put('api/categorie/' + id, studentObject)
            .then((res) => {
                console.log(res.data)
                console.log('categorie successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }

    // Make the context object:
    const categorieContext = {
        addNewGategorie,
        listGategorie,
        categories,
        deleteOneGategorie,
        updateGategorie
    };

    // pass the value in provider and return
    return <GategorieContext.Provider value = { categorieContext } > { children } < /GategorieContext.Provider>;
};