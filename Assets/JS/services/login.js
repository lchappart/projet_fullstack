export const login = async (username, password) => {
    const response = await fetch('index.php?component=login', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
            username: username,
            pass: password
        })
    })

    return await response.json()
}