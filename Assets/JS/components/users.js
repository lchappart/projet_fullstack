export const fillTableUsers = (data, tableBody) => {
    tableBody.innerHTML = ''
    for (let i = 0; i < data.length; i++) {
        const tr = document.createElement('tr')
        tr.innerHTML = `
                    <td>${data[i].id}</td>
                    <td>${data[i].username}</td>
                    <td><a href="#"><i class="is-enabled-icon ${data[i].enabled === 1 ? 'fa-solid fa-check text-success' : 'fa-solid fa-xmark text-danger'}" data-id="${data[i].id}"></i></a></td>
                    <td>
                         <a href="#" style="text-decoration: none" class="delete-btn">
                            <i class="fa-solid fa-trash text-danger" data-id="${data[i].id}"></i>
                        </a>
                        <a href="index.php?component=user&action=edit&id=${data[i].id}">
                            <i class="fa-solid fa-pen ms-3"></i>
                        </a>
                    </td>
                `
        tableBody.appendChild(tr)
    }
}