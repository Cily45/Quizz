export const login = async (username, password) => {

    const response = await fetch(`index.php?component=login`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        method: 'POST',
        body: new URLSearchParams({
            username,
            password
        })
    })

    return await response.json()
}

