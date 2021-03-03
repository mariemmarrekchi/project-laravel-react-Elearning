import axios from 'axios';


const ServiceUtilisateur = {};

ServiceUtilisateur.addNewUtilisateur = async(nom, prenom, password, token, expire_at, etat, id_compte) => {


    const utilisateurObject = {
        nom: nom,
        prenom: prenom,
        password: password,
        token: token,
        expire_at: expire_at,
        etat: etat,
        id_compte: id_compte
    };

    await axios.post('api/utilisateur', utilisateurObject)
        .then(res => console.log(res.data));

};
ServiceUtilisateur.listUtilisateur = async() => {

    const res = await axios.get('http://127.0.0.1:8000/api/utilisateur')
        .then(r => {

            return r.data;
        })
        .catch((error) => {
            console.log(error);
        })
    return res;

}
ServiceUtilisateur.deleteOneUtilisateur = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/utilisateur/${id}`)
        .then((res) => {
            console.log(res);
            // setUtilisateur(res);
            console.log('utilisateur successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listUtilisateur();
}

ServiceUtilisateur.updateUtilisateur = async(id, nom, prenom, password, token, expire_at, etat, id_compte) => {
    const utilisateurObject = {
        id: id,
        nom: nom,
        prenom: prenom,
        password: password,
        token: token,
        expire_at: expire_at,
        etat: etat,
        id_compte: id_compte
    };
    await axios.put('api/utilisateur/' + id, utilisateurObject)
        .then((res) => {
            console.log(res.data)
            console.log('utilisateur successfully updated')
        }).catch((error) => {
            console.log(error)
        })

}

// Make the context object:

export default ServiceUtilisateur;