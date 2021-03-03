import axios from 'axios';


const ServiceAbonnement = {};

ServiceAbonnement.addNewAbonnement = async(prix, promo, type, nature, etat, id_utilisateur, id_tarification) => {


    const abonnementObject = {
        prix: prix,
        promo: promo,
        type: type,
        nature: nature,
        etat: etat,
        id_utilisateur: id_utilisateur,
        id_tarification: id_tarification
    };

    await axios.post('api/abonnement', abonnementObject)
        .then(res => console.log(res.data));

};


ServiceAbonnement.listAbonnement = async() => {

    const result = await axios.get('http://127.0.0.1:8000/api/abonnement')
        .then(res => {
            return res.data;
        })
        .catch((error) => {
            console.log(error);
        })
    return result;
}
const deleteOneAbonnement = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/abonnement/${id}`)
        .then((res) => {
            console.log(res);
            // setAbonnement(res);
            console.log('abonnement successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listAbonnement();
}

ServiceAbonnement.updateAbonnement = async(id, prix, promo, type, nature, etat, id_utilisateur, id_tarification) => {
    const abonnementObject = {
        id: id,
        prix: prix,
        promo: promo,
        type: type,
        nature: nature,
        etat: etat,
        id_utilisateur: id_utilisateur,
        id_tarification: id_tarification
    };
    await axios.put('api/abonnement/' + id, abonnementObject)
        .then((res) => {
            console.log(res.data)
            console.log('abonnement successfully updated')
        }).catch((error) => {
            console.log(error)
        })

}

export default ServiceAbonnement;