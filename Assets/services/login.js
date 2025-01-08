export const login = async (username, password) => {
    console.log(2)
    const response = await fetch('index.php?component=login', {
        method: 'POST',
        body: new URLSearchParams({
            username: username,
            pass: password
        })
    })

    return await response.json()
}