export const getQuizzs = async (page)=>{
    const response = await fetch(`index.php?component=quizzs&page=${page}`,{
        headers:{
            'X-Requested-With':'XMLHttpRequest'
        }
    })
    return await response.json()
}

export const getQuizz = async (id)=>{
    let response = null

    if(id !== 0){
         response = await fetch(`index.php?component=quizz&id=${id}`,{
            headers:{
                'X-Requested-With':'XMLHttpRequest'
            }
        })
    }

    return await response !== null ? response.json() : response
}

export const createQuizz = async (data) => {
    const response = await fetch(`index.php?component=quizzAdmin&action=create`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        method: 'POST',
        body: JSON.stringify(data)
    })

    return response.json()
}

export const updateQuizz = async (data, id) => {
    const response = await fetch(`index.php?component=quizzAdmin&action=update&id=${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        method: 'POST',
        body: JSON.stringify(data)
    })
    return response.json()
}




