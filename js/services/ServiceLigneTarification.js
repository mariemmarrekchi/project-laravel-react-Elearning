import axios from 'axios';


const ServiceLigneTarification = {};

ServiceLigneTarification.addNewLigneTarification = async(titre, description, etat, id_tarification) => {


    const ligneTarificationObject = {
        titre: titre,
        description: description,
        etat: etat,
        id_id_tarificationcours: id_tarification
    };

    await axios.post('api/ligneTarification', ligneTarificationObject)
        .then(res => console.log(res.data));

};

ServiceLigneTarification.listLigneTarification = async() => {

    await axios.get('http://127.0.0.1:8000/api/ligneTarification')
        .then(res => {
            setLigneTarification(res.data);
            return res.data;
        })
        .catch((error) => {
            console.log(error);
        })

}


ServiceLigneTarification.deleteOneLigneTarification = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/ligneTarification/${id}`)
        .then((res) => {
            console.log(res);
            // setLigneTarification(res);
            console.log('LigneTarification successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listLigneTarification();
}

ServiceLigneTarification.updateLigneTarification = async(id, titre, description, image, id_LigneTarification) => {
    const ligneTarificationObject = {
        id: id,
        titre: titre,
        description: description,
        image: image,
        id_LigneTarification: id_LigneTarification
    };
    await axios.put('api/ligneTarification/' + id, ligneTarificationObject)
        .then((res) => {
            console.log(res.data)
            console.log('LigneTarification successfully updated')
        }).catch((error) => {
            console.log(error)
        })

}


// Make the context object:

export default ServiceLigneTarification;