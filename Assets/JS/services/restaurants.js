export const getRestaurants = async (currentPage) => {
  const response = await fetch(`index.php?component=restaurants&page=${currentPage}`,{
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
  return await response.json();
}

export const deleteRestaurant = async (id) => {
    const response = await fetch(`index.php?component=restaurants&action=delete&id=${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })

    return response.json()
}

export const toggleEnabledRestaurants = async (id, currentPage) => {
    const response = await fetch(`index.php?component=restaurants&action=toggleEnabled&id=${id}&page=${currentPage}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })

    return response.json()

}

export const countRestaurants = async () => {
    const response = await fetch('index.php?component=restaurants&action=count', {
        headers: {
        'X-Requested-With' : 'XMLHttpRequest'
        }
    })

    return response.json()
}
