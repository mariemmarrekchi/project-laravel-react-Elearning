import axios from 'axios';


const ServiceCours = {};

ServiceCours.addNewCours = async(titre, image, couverture, media, description, etat, nature, id_categorie, id_utilisateur) => {


    const CoursObject = {
        titre: titre,
        image: image,
        couverture: couverture,
        media: media,
        description: description,
        etat: etat,
        nature: nature,
        id_categorie: id_categorie,
        id_utilisateur: id_utilisateur


    };

    await axios.post('api/cours', CoursObject)
        .then(res => console.log(res.data));

};



ServiceCours.listCours = async() => {

    const res = await axios.get('http://127.0.0.1:8000/api/cours')
        .then(r => {

            return r.data;
        })
        .catch((error) => {
            console.log(error);
        })
    return res;

}
ServiceCours.deleteOneCours = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/cours/${id}`)
        .then((res) => {
            console.log(res);
            // setCours(res);
            console.log('cours successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listCours();
}

ServiceCours.updateCours = async(id, titre, image, couverture, media, description, etat, nature, id_categorie, id_utilisateur) => {
    const coursObject = {
        id: id,
        titre: titre,
        image: image,
        couverture: couverture,
        media: media,
        description: description,
        etat: etat,
        nature: nature,
        id_categorie: id_categorie,
        id_utilisateur: id_utilisateur

    };
    await axios.put('api/cours/' + id, coursObject)
        .then((res) => {
            console.log(res.data)
            console.log('Cours successfully updated')
        }).catch((error) => {
            console.log(error)
        })

}

// Make the context object:

export default ServiceCours;