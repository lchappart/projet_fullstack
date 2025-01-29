export const getUsers = async (currentPage, sortby = null) => {
    let query = `index.php?component=users&page=${currentPage}&sortby=${sortby}`
    const response = await fetch(query, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })

    return response.json()
}


export const toggleEnabled = async (id, currentPage) => {
    const response = await fetch(`index.php?component=users&action=toggleEnabled&id=${id}&page=${currentPage}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })

    return response.json()
}

export const deleteUser = async (id) => {
    const response = await fetch(`index.php?component=users&action=delete&id=${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })

    return response.json()
}

export const countUsers = async () => {
    const response = await fetch('index.php?component=users&action=count', {
        headers: {
        'X-Requested-With' : 'XMLHttpRequest'
        }
    })

    return response.json()
}
export const getIdByUsername = async (username) => {
    const response = await fetch(`index.php?component=users&action=idByUsername&username=${username}`, {
        headers: {
        'X-Requested-With' : 'XMLHttpRequest'
        }
    })

    return response.json()
}