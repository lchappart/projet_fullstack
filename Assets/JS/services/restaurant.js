export const getAddresses = async (data) => {
    const response = await fetch(`https://api-adresse.data.gouv.fr/search/?q=${encodeURI(data)}`)

    return await response.json()
}