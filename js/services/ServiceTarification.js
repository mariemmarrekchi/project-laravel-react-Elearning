import axios from 'axios';


const ServiceTarification = {};

ServiceTarification.addNewTarification = async(titre, description, prix) => {


    const tarificationObject = {
        titre: titre,
        description: description,
        prix: prix,
    };

    await axios.post('api/tarification', tarificationObject)
        .then(res => console.log(res.data));

};

ServiceTarification.listTarification = async() => {

    const res = await axios.get('http://127.0.0.1:8000/api/tarification')
        .then(r => {

            return r.data;
        })
        .catch((error) => {
            console.log(error);
        })
    return res;

}
ServiceTarification.deleteOneTarification = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/tarification/${id}`)
        .then((res) => {
            console.log(res);
            // setTarification(res);
            console.log('tarification successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listTarification();
}

ServiceTarification.updateTarification = async(id, titre, description, prix) => {
    const tarificationObject = {
        id: id,
        titre: titre,
        description: description,
        prix: prix,
    };
    await axios.put('api/tarification/' + id, tarificationObject)
        .then((res) => {
            console.log(res.data)
            console.log('tarification successfully updated')
        }).catch((error) => {
            console.log(error)
        })

}


// Make the context object:

export default Servicetarification;