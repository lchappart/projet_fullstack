export const getAddresses = async (data) => {
    const response = await fetch(`https://api-adresse.data.gouv.fr/search/?q=${encodeURI(data)}`)

    return await response.json()
}

export const getGroups = async () => {
    const response = await fetch(`index.php?component=restaurant&index=groups`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    return await response.json()
}