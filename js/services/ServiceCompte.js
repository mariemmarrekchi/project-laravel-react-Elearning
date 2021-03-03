import axios from 'axios';


const ServiceCompte = {};

ServiceCompte.addNewCompte = async(libelle, etat) => {


    const compteObject = {
        libelle: libelle,
        etat: etat,

    };

    await axios.post('api/compte', compteObject)
        .then(res => console.log(res.data));

};


ServiceCompte.listCompte = async() => {

    const res = await axios.get('http://127.0.0.1:8000/api/compte')
        .then(r => {

            return r.data;
        })
        .catch((error) => {
            console.log(error);
        })
    return res;

}
ServiceCompte.deleteOneCompte = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/compte/${id}`)
        .then((res) => {
            console.log(res);
            // setCompte(res);
            console.log('compte successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listCompte();
}

ServiceCompte.updateCompte = async(id, libelle, etat) => {
    const compteObject = {
        id: id,
        libelle: libelle,
        etat: etat,

    };
    await axios.put('api/compte/' + id, compteObject)
        .then((res) => {
            console.log(res.data)
            console.log('compte successfully updated')
        }).catch((error) => {
            console.log(error)
        })

}


// Make the context object:

export default ServiceCompte;