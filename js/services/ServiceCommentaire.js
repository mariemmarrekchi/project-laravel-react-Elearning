import axios from 'axios';


const ServiceCommentaire = {};

ServiceCommentaire.addNewCommentaire = async(text, date, id_publication, id_utilisateur) => {


    const commentaireObject = {
        text: text,
        date: date,
        id_publication: id_publication,
        id_utilisateur: id_utilisateur,


    };

    await axios.post('api/commentaire', commentaireObject)
        .then(res => console.log(res.data));

};


ServiceCommentaire.listCommentaire = async() => {

    const res = await axios.get('http://127.0.0.1:8000/api/commentaire')
        .then(r => {

            return r.data;
        })
        .catch((error) => {
            console.log(error);
        })
    return res;

}
ServiceCommentaire.deleteOneCommenatire = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/commentaire/${id}`)
        .then((res) => {
            console.log(res);
            // setGategorie(res);
            console.log('commentaire successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listGategorie();
}

ServiceCommentaire.updateCommentaire = async(id, text, date, id_publication, id_utilisateur) => {
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

export default ServiceCommentaire;