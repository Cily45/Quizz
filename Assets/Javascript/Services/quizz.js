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





