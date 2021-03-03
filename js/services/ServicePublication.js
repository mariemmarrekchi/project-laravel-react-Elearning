import axios from 'axios';


const ServicePublication = {};

ServicePublication.addNewPublication = async(titre, image, couverture, media, description, etat, nature, id_cours, id_utilisateur) => {


    const publicationObject = {
        titre: titre,
        image: image,
        couverture: couverture,
        media: media,
        description: description,
        etat: etat,
        nature: nature,
        id_cours: id_cours,
        id_utilisateur: id_utilisateur


    };

    await axios.post('api/publication', publicationObject)
        .then(res => console.log(res.data));

};

ServicePublication.listGategorie = async() => {

    const res = await axios.get('http://127.0.0.1:8000/api/publication')
        .then(r => {

            return r.data;
        })
        .catch((error) => {
            console.log(error);
        })
    return res;

}
ServicePublication.deleteOneGategorie = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/publication/${id}`)
        .then((res) => {
            console.log(res);
            // setGategorie(res);
            console.log('publication successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listGategorie();
}

ServicePublication.updatePublication = async(id, titre, image, couverture, media, description, etat, nature, id_cours, id_utilisateur) => {
    const publicationObject = {
        id: id,
        titre: titre,
        image: image,
        couverture: couverture,
        media: media,
        description: description,
        etat: etat,
        nature: nature,
        id_cours: id_cours,
        id_utilisateur: id_utilisateur

    };
    await axios.put('api/publication/' + id, publicationObject)
        .then((res) => {
            console.log(res.data)
            console.log('Publication successfully updated')
        }).catch((error) => {
            console.log(error)
        })

}


// Make the context object:

export default ServicePublication;