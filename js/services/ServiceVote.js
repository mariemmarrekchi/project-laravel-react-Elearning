import axios from 'axios';
const ServiceVote = {};

ServiceVote.addNewVote = async(nombre, id_utilisateur, id_cours) => {


    const voteObject = {
        nombre: nombre,
        id_utilisateur: id_utilisateur,
        id_cours: id_cours,

    };

    await axios.post('api/vote', voteObject)
        .then(res => console.log(res.data));

};

Servicevote.listVote = async() => {

    const res = await axios.get('http://127.0.0.1:8000/api/vote')
        .then(r => {

            return r.data;
        })
        .catch((error) => {
            console.log(error);
        })
    return res;

}
Servicevote.deleteOneVote = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/vote/${id}`)
        .then((res) => {
            console.log(res);
            // setvote(res);
            console.log('vote successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listvote();
}

Servicevote.updateVote = async(id, nombre, id_utilisateur, id_cours) => {
    const voteObject = {
        id: id,
        nombre: nombre,
        id_utilisateur: id_utilisateur,
        id_cours: id_cours,

    };
    await axios.put('api/vote/' + id, voteObject)
        .then((res) => {
            console.log(res.data)
            console.log('vote successfully updated')
        }).catch((error) => {
            console.log(error)
        })

}

// Make the context object:

export default Servicevote;