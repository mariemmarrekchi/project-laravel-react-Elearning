import axios from 'axios';


const ServiceQuestionnairenaire = {};

ServiceQuestionnairenaire.addNewquestionnaire = async(libelle, datedebut, datefin, description, type, etat, id_cours, id_utilisateur) => {


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

ServiceQuestionnaire.listGategorie = async() => {

    const res = await axios.get('http://127.0.0.1:8000/api/questionnaire')
        .then(r => {

            return r.data;
        })
        .catch((error) => {
            console.log(error);
        })
    return res;

}
ServiceQuestionnaire.deleteOneGategorie = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/questionnaire/${id}`)
        .then((res) => {
            console.log(res);
            // setGategorie(res);
            console.log('questionnaire successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listGategorie();
}

ServiceQuestionnaire.updatequestionnaire = async(id, libelle, datedebut, datefin, description, type, etat, id_cours, id_utilisateur) => {
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

export default ServiceQuestionnaire;