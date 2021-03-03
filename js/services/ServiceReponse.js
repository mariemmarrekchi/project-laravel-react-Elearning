import axios from 'axios';


const ServiceReponse = {};

ServiceReponse.addNewReponse = async(text, etat, id_question) => {


    const reponseObject = {
        text: text,
        etat: etat,
        nature: nature,
        id_question: id_question


    };

    await axios.post('api/reponse', reponseObject)
        .then(res => console.log(res.data));

};

ServiceReponse.listReponse = async() => {

    const res = await axios.get('http://127.0.0.1:8000/api/reponse')
        .then(r => {

            return r.data;
        })
        .catch((error) => {
            console.log(error);
        })
    return res;

}
ServiceReponse.deleteOneReponse = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/reponse/${id}`)
        .then((res) => {
            console.log(res);
            // setReponse(res);
            console.log('reponse successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listReponse();
}

ServiceReponse.updateReponse = async(id, text, etat, id_question) => {
        const reponseObject = {
            id: id,
            text: text,
            etat: etat,
            id_question: id_question,

        };
        await axios.put('api/reponse/' + id, reponseObject)
            .then((res) => {
                console.log(res.data)
                console.log('Reponse successfully updated')
            }).catch((error) => {
                console.log(error)
            })

    }
    // Make the context object:

export default ServiceReponse;