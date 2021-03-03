import axios from 'axios';


const ServiceChoix = {};

ServiceChoix.addNewChoix = async(id_utlisateur, id_reponse) => {


    const choixObject = {
        id_utlisateur: id_utlisateur,
        id_reponse: id_reponse,

    };

    await axios.post('api/choix', choixObject)
        .then(res => console.log(res.data));

};


ServiceChoix.listChoix = async() => {

    const result = await axios.get('http://127.0.0.1:8000/api/choix')
        .then(res => {

            return res.data;
        })
        .catch((error) => {
            console.log(error);
        })
    return result;
}

ServiceChoix.deleteOneChoix = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/choix/${id}`)
        .then((res) => {
            console.log(res);
            // setChoix(res);
            console.log('choix successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listChoix();
}
ServiceChoix.updateChoix = async(id, id_utlisateur, id_reponse) => {
        const choixObject = {
            id: id,
            id_utlisateur: id_utlisateur,
            id_reponse: id_reponse,


        };
        await axios.put('api/choix/' + id, choixObject)
            .then((res) => {
                console.log(res.data)
                console.log('choix successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }
    // Make the context object:

export default ServiceChoix;