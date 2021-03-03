import axios from 'axios';


const ServiceCategorie = {};

ServiceCategorie.addNewGategorie = async(titre, description, image, id_categorie) => {


    const categorieObject = {
        titre: titre,
        description: description,
        image: image,
        id_categorie: id_categorie
    };

    await axios.post('http://127.0.0.1:8000/api/categorie', categorieObject)
        .then(res => console.log(res.data));

};

ServiceCategorie.listGategorie = async() => {

    const res = await axios.get('http://127.0.0.1:8000/api/categorie')
        .then(r => {

            return r.data;
        })
        .catch((error) => {
            console.log(error);
        })
    return res;

}
ServiceCategorie.deleteOneGategorie = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/categorie/${id}`)
        .then((res) => {
            console.log(res);
            // setGategorie(res);
            console.log('categorie successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listGategorie();
}

ServiceCategorie.updateGategorie = async(id, titre, description, image, id_categorie) => {
    const studentObject = {
        id: id,
        titre: titre,
        description: description,
        image: image,
        id_categorie: id_categorie
    };
    await axios.put('api/categorie/' + id, studentObject)
        .then((res) => {
            console.log(res.data)
            console.log('categorie successfully updated')
        }).catch((error) => {
            console.log(error)
        })

}

// Make the context object:

export default ServiceCategorie;