export const getQuizzs = async (page)=>{
    const response = await fetch(`index.php?component=quizzs&page=${page}`,{
        headers:{
            'X-Requested-With':'XMLHttpRequest'
        }
    })
    return await response.json()
}

export const getQuizz = async (id)=>{
    const response = await fetch(`index.php?component=quizz&id=${id}`,{
        headers:{
            'X-Requested-With':'XMLHttpRequest'
        }
    })
    return await response.json()
}

export const getQuizzsAdmin = async (page, sortby)=>{
    const response = await fetch(`index.php?component=quizzsAdmin&page=${page}&sortby=${sortby}`,{
        headers:{
            'X-Requested-With':'XMLHttpRequest'
        }
    })
    return await response.json()
}

export const getQuizzAdmin = async (id)=>{
    const response = await fetch(`index.php?component=quizzAdmin&id=${id}`,{
        headers:{
            'X-Requested-With':'XMLHttpRequest'
        }
    })
    return await response.json()
}

export const deletteQuizz = async  (id) =>{
    const response = await fetch(`index.php?component=quizzsAdmin&action=delete&id=${id}`,{
        headers:{
            'X-Requested-With':'XMLHttpRequest'
        }
    })
}

export const updateIsPublishedQuizz = async  (id,isPublished) =>{
    const response = await fetch(`index.php?component=quizzsAdmin&action=updateIsPublished&id=${id}&isPublished=${isPublished}`,{
        headers:{
            'X-Requested-With':'XMLHttpRequest'
        }
    })
}