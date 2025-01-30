export const fillTableRestaurants = (data, tableBody) => {
    tableBody.innerHTML = ''
    for (let i = 0; i < data.restaurants.length; i++) {
        const tr = document.createElement('tr')
        tr.innerHTML = `
                    <td>${data.restaurants[i].id}</td>
                    <td>${data.restaurants[i].manager}</td>
                    <td>${data.restaurants[i].siret_siren}</td>
                    <td>${data.restaurants[i].address}</td>
                    <td>${data.restaurants[i].opening_hours}</td>
                    <td>${data.groups[data.restaurants[i].group_id - 1].name}</td>
                    <td>
                        <a href="#" style="text-decoration: none" class="delete-btn">
                            <i class="fa-solid fa-trash text-danger" data-id="${data.restaurants[i].id}"></i>
                        </a>
                        <a href="index.php?component=restaurant&action=edit&id=${data.restaurants[i].id}">
                            <i class="fa-solid fa-pen ms-3"></i>
                        </a>
                    </td>
                `
        tableBody.appendChild(tr)
    }
}