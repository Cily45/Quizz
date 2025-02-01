export const getQuizzs = async (page)=>{

    const response = await fetch(`index.php?component=quizzs&page=${page}`,{
        headers:{
            'X-Requested-With':'XMLHttpRequest'
        },
        method: 'POST',
    })

    return await response.json()
}

export const getQuizz = async (id)=>{
    let response = null

    if(id !== 0){
         response = await fetch(`index.php?component=quizz&id=${id}`,{
            headers:{
                'X-Requested-With':'XMLHttpRequest',
                method: 'POST',
            }
        })
    }

    return await response !== null ? response.json() : response
}

export const addTime = async (id, time) => {
    const formData = new FormData();
    formData.append('time', time);
    const response = await fetch(`index.php?component=quizz&id=${id}&action=result`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        method: 'POST',
        body: formData
    })

    return response.json()
}



