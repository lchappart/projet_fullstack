export const fillTableUsers = (data, tableBody) => {
    tableBody.innerHTML = ''
    for (let i = 0; i < 15; i++) {
        const tr = document.createElement('tr')
        tr.innerHTML = `
                    <td>${data[i].id}</td>
                    <td>${data[i].username}</td>
                    <td><a href="#"><i class="is-enabled-icon ${data[i].enabled === 1 ? 'fa-solid fa-check text-success' : 'fa-solid fa-xmark text-danger'}" data-id="${data[i].id}"></i></a></td>
                    <td>
                        <a href="#"
                               style="text-decoration: none;"
                            >
                            <i class="fa-solid fa-trash text-danger delete-icon" 
                            data-id="${data[i].id}"
                            onabort="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')"
                            ></i>
                        </a>
                        <a href="index.php?component=users&action=edit&id=${data[i].id}">
                            <i class="fa-solid fa-pen ms-3"></i>
                        </a>
                    </td>
                `
        tableBody.appendChild(tr)
    }
}