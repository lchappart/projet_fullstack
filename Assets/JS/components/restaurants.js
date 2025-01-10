export const fillTableRestaurants = (data, tableBody) => {
    tableBody.innerHTML = ''
    for (let i = 0; i < data.length; i++) {
        const tr = document.createElement('tr')
        tr.innerHTML = `
                    <td>${data[i].id}</td>
                    <td>${data[i].manager}</td>
                    <td>${data[i].siret_siren}</td>
                    <td>${data[i].address}</td>
                    <td>${data[i].opening_hours}</td>
                    <td>
                        <a href="#"
                               style="text-decoration: none;"
                            >
                            <i class="fa-solid fa-trash text-danger delete-icon" 
                            data-id="${data[i].id}"
                            onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')"
                            ></i>
                        </a>
                        <a href="index.php?component=restaurant&action=edit&id=${data[i].id}">
                            <i class="fa-solid fa-pen ms-3"></i>
                        </a>
                    </td>
                `
        tableBody.appendChild(tr)
    }
}