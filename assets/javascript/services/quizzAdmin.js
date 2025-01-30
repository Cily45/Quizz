export const getQuizzsAdmin = async (page, sortby) => {

    const response = await fetch(`index.php?component=quizzsAdmin&page=${page}&sortby=${sortby}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        method: 'POST',
    })

    return await response.json()
}

export const getQuizzAdmin = async (id) => {

    const response = await fetch(`index.php?component=quizzAdmin&id=${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        method: 'POST',
    })

    return await response.json()
}
export const deletteQuizz = async (page, sortBy, id) => {

    const response = await fetch(`index.php?component=quizzsAdmin&action=delete&page=${page}&sortby=${sortBy}&id=${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        method: 'POST',
    })

    return await response.json()
}

export const updateIsPublishedQuizz = async (page, sortBy, id) => {

    const response = await fetch(`index.php?component=quizzsAdmin&action=updateIsPublished&page=${page}&sortby=${sortBy}&id=${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        method: 'POST',
    })

    return await response.json()
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