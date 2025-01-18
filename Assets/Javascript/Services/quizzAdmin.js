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
export const deletteQuizz = async  (page, sortBy, id) =>{
    const response = await fetch(`index.php?component=quizzsAdmin&action=delete&page=${page}&sortby=${sortBy}&id=${id}`,{
        headers:{
            'X-Requested-With':'XMLHttpRequest'
        }
    })
    return await response.json()
}

export const updateIsPublishedQuizz = async  (page, sortBy, id) =>{
    const response = await fetch(`index.php?component=quizzsAdmin&action=updateIsPublished&page=${page}&sortby=${sortBy}&id=${id}`,{
        headers:{
            'X-Requested-With':'XMLHttpRequest'
        }
    })
    return await response.json()

}