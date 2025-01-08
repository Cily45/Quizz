export const getQuizz = async (page,limit)=>{
    const response = await fetch(`index.php?component=quizzs&page=${page}&limit=${limit}`,{
        headers:{
            'X-Requested-With':'XMLHttpRequest'
        }
    })
    return await response.json()
}