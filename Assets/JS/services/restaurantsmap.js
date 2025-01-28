export const getAllRestaurants = async () => {
  const response = await fetch("index.php?component=restaurantsmap&action=restaurants", {
      headers: {
          'X-Requested-With': 'XMLHttpRequest'
      }
  })

  return await response.json()
}

export const getCoordinates = async (data) => {
  const response = await fetch(`https://api-adresse.data.gouv.fr/search/?q=${data}`)

  return await response.json()
}

export const getDepartementsData = async () => {
    const response = await fetch(`index.php?component=restaurantsmap&action=departements`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })

    return await response.json()
}