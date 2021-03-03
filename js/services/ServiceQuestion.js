import axios from 'axios';


const ServiceQuestion = {};

ServiceQuestion.addNewQuestion = async(titre, description, image, id_question) => {


    const questionObject = {
        titre: titre,
        description: description,
        image: image,
        id_question: id_question
    };

    await axios.post('http://127.0.0.1:8000/api/question', questionObject)
        .then(res => console.log(res.data));

};

ServiceQuestion.listQuestion = async() => {

    const res = await axios.get('http://127.0.0.1:8000/api/question')
        .then(r => {

            return r.data;
        })
        .catch((error) => {
            console.log(error);
        })
    return res;

}
ServiceQuestion.deleteOneQuestion = async(id) => {
    console.log(id);
    await axios.delete(`http://127.0.0.1:8000/api/question/${id}`)
        .then((res) => {
            console.log(res);
            // setQuestion(res);
            console.log('question successfully deleted!')
        }).catch((error) => {
            console.log(error)

        })
        //return listQuestion();
}

ServiceQuestion.updateQuestion = async(id, titre, description, etat, type, id_questionnaire) => {
    const questionObject = {
        id: id,
        titre: titre,
        description: description,
        etat: etat,
        type: type,
        id_questionnaire: id_questionnaire,


    };
    await axios.put('api/question/' + id, questionObject)
        .then((res) => {
            console.log(res.data)
            console.log('Question successfully updated')
        }).catch((error) => {
            console.log(error)
        })

}

// Make the context object:

export default ServiceQuestion;