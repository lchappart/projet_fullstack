<?php
/**
 * @var array $users
 */
?>

<div class="mt-5 mb-5">
    <h1 class="text-center">Liste des utilisateurs :</h1>
</div>
<a href="index.php?component=user&action=create">
    <button type="button" class="btn btn-primary">+ Créer un utlisateur</button>
</a>
<div class="row">
    <table class="table">
        <thead>
        <tr>
            <th  scope="col">
                <a id="sort-by-id" style="text-decoration: none;color:<?php echo (isset($_GET['sortby']) && $_GET['sortby'] === 'id' ? 'blue' : 'black') ;?>;" href="#">
                    ID <i class="fa-solid fa-chevron-down"></i>
                </a>
            </th>
            <th scope="col">
                <a id="sort-by-username" style="text-decoration: none;color:<?php echo (isset($_GET['sortby']) && $_GET['sortby'] === 'username' ? 'blue' : 'black') ;?>;" href="#">
                    Username <i class="fa-solid fa-chevron-down"></i>
                </a>
            </th>
            <th scope="col">Actif</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody id="table-body-users">

        </tbody>
    </table>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#" id="previous-page">Previous</a></li>
            <li class="page-item"><a class="page-link" href="#" id="first-page-btn"></a></li>
            <li class="page-item"><a class="page-link" href="#" id="current-page"></a></li>
            <li class="page-item"><a class="page-link" href="#" id="last-page-btn"></a></li>
            <li class="page-item"><a class="page-link" href="#" id="next-page">Next</a></li>
        </ul>
    </nav>
</div>
<script src= "./Assets/JS/components/users.js" type="module"></script>
<script src= "./Assets/JS/services/users.js" type="module"></script>
<script type="module">
    import {toggleEnabled} from "./Assets/JS/services/users.js"
    import {getUsers} from "./Assets/JS/services/users.js"
    import {fillTableUsers} from "./Assets/JS/components/users.js"
    import {deleteUser} from "./Assets/JS/services/users.js"
    import {countUsers} from "./Assets/JS/services/users.js";

    document.addEventListener('DOMContentLoaded', async () => {
        let currentPage = 1
        let sortBy = 'id'
        const totalUsers = await countUsers()
        const tableBody = document.querySelector('#table-body-users')
        const previousPage = document.querySelector('#previous-page')
        const nextPage = document.querySelector('#next-page')
        const firstPageBtn = document.querySelector('#first-page-btn')
        const lastPageBtn = document.querySelector('#last-page-btn')
        const currentPageElement = document.querySelector('#current-page')
        const sortById = document.querySelector('#sort-by-id')
        const sortByUsername = document.querySelector('#sort-by-username')
        let data = await getUsers(currentPage)
        fillTableUsers(data, tableBody, currentPage)
        const addToggleDeleteListeners = () => {
            const isEnabledIcons = document.querySelectorAll('.is-enabled-icon')
            const deleteIcons = document.querySelectorAll('.delete-icon')
            for (let i = 0; i < isEnabledIcons.length; i++) {
                isEnabledIcons[i].addEventListener('click', async (e) => {
                    e.preventDefault()
                    const id = e.target.getAttribute('data-id')
                    toggleEnabled(id, currentPage)
                    e.preventDefault()
                    e.target.classList.toggle('fa-check')
                    e.target.classList.toggle('fa-xmark')
                    e.target.classList.toggle('text-success')
                    e.target.classList.toggle('text-danger')
                })
            }

            for (let i = 0; i < deleteIcons.length; i++) {
                deleteIcons[i].addEventListener('click', async (e) => {
                    e.preventDefault()
                    const id = e.target.getAttribute('data-id')
                    const data = await deleteUser(id)
                    fillTableUsers(data, tableBody, currentPage)
                })
            }
        }

        addToggleDeleteListeners()
        firstPageBtn.innerHTML = '1'
        currentPageElement.innerHTML = currentPage
        lastPageBtn.innerHTML = Math.ceil(totalUsers[0] / 15)

        previousPage.addEventListener('click',  (e) => {
            e.preventDefault()
            updatePagination(-1)
        })

        nextPage.addEventListener('click',  (e) => {
            e.preventDefault()
            updatePagination(1)
        })

        firstPageBtn.addEventListener('click',  (e) => {
            e.preventDefault()
            currentPage = 1
            tableBody.innerHTML = ''
            fillTableUsers(data, tableBody, currentPage)
        })

        lastPageBtn.addEventListener('click', async (e) => {
            e.preventDefault()
            currentPage = Math.ceil(totalUsers[0] / 15)
            tableBody.innerHTML = ''
            const data = await getUsers(currentPage)
            fillTableUsers(data, tableBody)
        })

        sortById.addEventListener('click', async (e) => {
            e.preventDefault()
            currentPage = 1
            data = await getUsers(currentPage, 'id')
            tableBody.innerHTML = ''
            fillTableUsers(data, tableBody)
        })

        sortByUsername.addEventListener('click', async (e) => {
            sortBy = 'username'
            const data = await getUsers(currentPage, sortBy)
            fillTableUsers(data, tableBody, currentPage)
        })

        const updatePagination = async (gap) => {
            currentPage = currentPage + gap
            if (currentPage < 1) {
                currentPage = 1
            }
            tableBody.innerHTML = ''
            const data = await getUsers(currentPage)
            currentPageElement.innerHTML = currentPage
            fillTableUsers(data, tableBody, currentPage)
            addToggleDeleteListeners()
        }
    })
</script>