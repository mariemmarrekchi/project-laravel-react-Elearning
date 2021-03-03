import axios from 'axios';


const ServiceVisite = {};

ServiceVisite.addNewVisite = async(date, id_publication, id_utilisateur) => {


    const visiteObject = {
        date: date,
        id_publication: id_publication,
        id_utilisateur: id_utilisateur,

    };

    await axios.post('api/visite', visiteObject)
        .then(res => console.log(res.data));

};

ServiceVisite.listVisite = async() => {

    const res = await axios.get('http://127.0.0.1:8000/api/visite')
        .then(r => {

            return r.data;
        })
        .catch((error) => {
            console.log(error);
        })
    return res;

}
ServiceVisite.deleteOneVisite = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/visite/${id}`)
        .then((res) => {
            console.log(res);
            // setVisite(res);
            console.log('visite successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listVisite();
}

ServiceVisite.updateVisite = async(id, date, id_publication, id_utilisateur) => {
    const visiteObject = {
        id: id,
        date: date,
        id_publication: id_publication,
        id_utilisateur: id_utilisateur

    };
    await axios.put('api/visite/' + id, visiteObject)
        .then((res) => {
            console.log(res.data)
            console.log('visite successfully updated')
        }).catch((error) => {
            console.log(error)
        })

}

// Make the context object:

export default ServiceVisite;