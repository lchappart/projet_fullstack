<?php
/**
 * @var array $users
 */
?>

<div class="mt-5 mb-5">
    <h1 class="text-center">Liste des restaurants :</h1>
</div>
<a href="index.php?component=restaurant&action=create">
    <button type="button" class="btn btn-primary">+ Créer un restaurant</button>
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
                <a id="sort-by-manager" style="text-decoration: none;color:<?php echo (isset($_GET['sortby']) && $_GET['sortby'] === 'username' ? 'blue' : 'black') ;?>;" href="#">
                    Manager <i class="fa-solid fa-chevron-down"></i>
                </a>
            </th>
            <th scope="col">
                <a href="#">
                    Siret-Siren <i class="fa-solid fa-chevron-down"></i>
                </a>
            </th>
            <th scope="col">
                <a href="#">
                    Adresse <i class="fa-solid fa-chevron-down"></i>
                </a>
            </th>
            <th scope="col">
                <a href="#">
                    Horaires d'ouvertures <i class="fa-solid fa-chevron-down"></i>
                </a>
            </th>
            <th scope="col">
                Action
            </th>
        </tr>
        </thead>
        <tbody id="table-body-restaurants">

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
<script src= "./Assets/JS/components/restaurants.js" type="module"></script>
<script src="./Assets/JS/components/restaurants.js" type="module"></script>
<script type="module">
    import {getRestaurants} from "./Assets/JS/services/restaurants.js"
    import {fillTableRestaurants} from "./Assets/JS/components/restaurants.js"
    import {deleteRestaurant} from "./Assets/JS/services/restaurants.js"
    import {countRestaurants} from "./Assets/JS/services/restaurants.js";

    document.addEventListener('DOMContentLoaded', async () => {
        let currentPage = 1
        let sortBy = 'id'
        const totalRestaurants = await countRestaurants()
        const tableBody = document.querySelector('#table-body-restaurants')
        const previousPage = document.querySelector('#previous-page')
        const nextPage = document.querySelector('#next-page')
        const firstPageBtn = document.querySelector('#first-page-btn')
        const lastPageBtn = document.querySelector('#last-page-btn')
        const currentPageElement = document.querySelector('#current-page')
        let data = await getRestaurants(currentPage)
        fillTableRestaurants(data, tableBody, currentPage)
        const addToggleDeleteListeners = () => {
            const deleteIcons = document.querySelectorAll('.delete-icon')
            for (let i = 0; i < deleteIcons.length; i++) {
                deleteIcons[i].addEventListener('click', async (e) => {
                    e.preventDefault()
                    const id = e.target.getAttribute('data-id')
                    const data = await deleteRestaurant(id)
                    fillTableRestaurants(data, tableBody)
                })
            }
        }

        addToggleDeleteListeners()
        firstPageBtn.innerHTML = '1'
        currentPageElement.innerHTML = currentPage
        lastPageBtn.innerHTML = Math.ceil(totalRestaurants[0] / 15)

        previousPage.addEventListener('click',  (e) => {
            e.preventDefault()
            updatePagination(-1)
        })

        nextPage.addEventListener('click',  (e) => {
            e.preventDefault()
            updatePagination(1)
        })

        firstPageBtn.addEventListener('click', async(e) => {
            e.preventDefault()
            currentPage = 1
            currentPageElement.innerHTML = currentPage
            tableBody.innerHTML = ''
            const data = await getRestaurants(currentPage)
            fillTableRestaurants(data, tableBody, currentPage)
        })

        lastPageBtn.addEventListener('click', async (e) => {
            e.preventDefault()
            currentPage = Math.ceil(totalRestaurants[0] / 15)
            tableBody.innerHTML = ''
            currentPageElement.innerHTML = currentPage
            const data = await getRestaurants(currentPage)
            fillTableRestaurants(data, tableBody)
        })

        // sortById.addEventListener('click', async (e) => {
        //     e.preventDefault()
        //     currentPage = 1
        //     data = await getUsers(currentPage, 'id')
        //     tableBody.innerHTML = ''
        //     fillTableUsers(data, tableBody)
        // })
        //
        // sortByUsername.addEventListener('click', async (e) => {
        //     sortBy = 'username'
        //     const data = await getUsers(currentPage, sortBy)
        //     fillTableUsers(data, tableBody, currentPage)
        // })

        const updatePagination = async (gap) => {
            currentPage = currentPage + gap
            if (currentPage < 1) {
                currentPage = 1
            }
            tableBody.innerHTML = ''
            const data = await getRestaurants(currentPage)
            currentPageElement.innerHTML = currentPage
            fillTableRestaurants(data, tableBody, currentPage)
            addToggleDeleteListeners()
        }
    })
</script>