<?php
/**
 * @var array $users
 */
?>

<div class="mt-5 mb-5">
    <h1 class="text-center">Liste des restaurants :</h1>
</div>
<div class="autoComplete_wrapper mb-5 mt-5 d-block align-content-center">
    <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" autocapitalize="off">
</div>
<a href="index.php?component=restaurant&action=create">
    <button type="button" class="btn btn-primary">+ Créer un restaurant</button>
</a>
<div class="row">
    <table class="table">
        <thead>
        <tr>
            <th  scope="col">
                <a id="sort-by-id" style="text-decoration: none; color:black;" href="#">
                    ID <i class="fa-solid fa-chevron-down"></i>
                </a>
            </th>
            <th scope="col">
                <a id="sort-by-manager" style=" text-decoration: none; color:black;" href="#">
                    Manager <i class="fa-solid fa-chevron-down"></i>
                </a>
            </th>
            <th scope="col">
                <a id="sort-by-siren" href="#" style="text-decoration: none;color:black;">
                    Siret-Siren <i class="fa-solid fa-chevron-down"></i>
                </a>
            </th>
            <th scope="col">
                <a id="sort-by-address" href="#" style="text-decoration: none;color:black;">
                    Adresse <i class="fa-solid fa-chevron-down"></i>
                </a>
            </th>
            <th scope="col">
                <a id="sort-by-hours" href="#" style="text-decoration: none;color:black;">
                    Horaires d'ouvertures <i class="fa-solid fa-chevron-down"></i>
                </a>
            </th>
            <th>
                <a id="sort-by-group" href="#" style="text-decoration: none;color:black;">
                    Groupe <i class="fa-solid fa-chevron-down"></i>
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
<script src= "./Assets/JS/services/restaurants.js" type="module"></script>
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
        const sortById = document.querySelector('#sort-by-id')
        const sortByManager = document.querySelector('#sort-by-manager')
        const sortBySiren = document.querySelector('#sort-by-siren')
        const sortByAddress = document.querySelector('#sort-by-address')
        const sortByHours = document.querySelector('#sort-by-hours')
        const sortByGroup = document.querySelector('#sort-by-group')
        const previousPage = document.querySelector('#previous-page')
        const nextPage = document.querySelector('#next-page')
        const firstPageBtn = document.querySelector('#first-page-btn')
        const lastPageBtn = document.querySelector('#last-page-btn')
        const currentPageElement = document.querySelector('#current-page')
        let data = await getRestaurants(currentPage, sortBy)
        await fillTableRestaurants(data, tableBody)
        const addToggleDeleteListeners = () => {
            const deleteIcons = document.querySelectorAll('.delete-btn')
            for (let i = 0; i < deleteIcons.length; i++) {
                deleteIcons[i].addEventListener('click', async (e) => {
                    e.preventDefault()
                    const id = e.target.getAttribute('data-id')
                    const data = await deleteRestaurant(id)
                    fillTableRestaurants(data, tableBody)
                    addToggleDeleteListeners()
                })
            }
        }

        const autoCompleteJS = new autoComplete({
            selector: '#autoComplete',
            placeHolder: "Recherchez...",
            data: {
                src: async (query) => {
                    const response = await fetch(
                        `index.php?component=restaurants&action=search&query=${query}`,
                        {
                            headers: {
                                'X-Requested-With' : 'XMLHttpRequest'
                            }
                        }
                    )
                    return await response.json()
                },
                keys: ['manager', 'id', 'siret_siren', 'address', 'opening_hours'],
            },
        })
        autoCompleteJS.input.addEventListener('selection', async (e) => {
            const id = e.detail.selection.value.id
            window.location.href = 'index.php?component=restaurant&action=edit&id=' + id
        })

        sortById.addEventListener('click', async (e) => {
            e.preventDefault()
            sortBy = 'id'
            tableBody.innerHTML = ''
            const data = await getRestaurants(currentPage, sortBy)
            fillTableRestaurants(data, tableBody)
            addToggleDeleteListeners()
        })

        sortByManager.addEventListener('click', async (e) => {
            e.preventDefault()
            sortBy = 'manager'
            tableBody.innerHTML = ''
            const data = await getRestaurants(currentPage, sortBy)
            fillTableRestaurants(data, tableBody)
            addToggleDeleteListeners()
        })

        sortBySiren.addEventListener('click', async (e) => {
            e.preventDefault()
            sortBy = 'siret_siren'
            tableBody.innerHTML = ''
            const data = await getRestaurants(currentPage, sortBy)
            fillTableRestaurants(data, tableBody)
            addToggleDeleteListeners()
        })

        sortByAddress.addEventListener('click', async (e) => {
            e.preventDefault()
            sortBy = 'address'
            tableBody.innerHTML = ''
            const data = await getRestaurants(currentPage, sortBy)
            fillTableRestaurants(data, tableBody)
            addToggleDeleteListeners()
        })

        sortByHours.addEventListener('click', async (e) => {
            e.preventDefault()
            sortBy = 'opening_hours'
            tableBody.innerHTML = ''
            const data = await getRestaurants(currentPage, sortBy)
            fillTableRestaurants(data, tableBody)
            addToggleDeleteListeners()
        })

        sortByGroup.addEventListener('click', async (e) => {
            e.preventDefault()
            sortBy = 'group_id'
            tableBody.innerHTML = ''
            const data = await getRestaurants(currentPage, sortBy)
            fillTableRestaurants(data, tableBody)
            addToggleDeleteListeners()
        })

        addToggleDeleteListeners()
        firstPageBtn.innerHTML = '1'
        currentPageElement.innerHTML = currentPage
        lastPageBtn.innerHTML = Math.ceil(totalRestaurants[0] / 15)

        previousPage.addEventListener('click',  (e) => {
            if (currentPage !== 1) {
                e.preventDefault()
                updatePagination(-1)
            }
        })

        nextPage.addEventListener('click',  (e) => {
            if (currentPage !== Math.ceil(totalRestaurants[0] / 15)) {
                e.preventDefault()
                updatePagination(1)
            }
        })

        firstPageBtn.addEventListener('click', async(e) => {
            e.preventDefault()
            currentPage = 1
            currentPageElement.innerHTML = currentPage
            tableBody.innerHTML = ''
            const data = await getRestaurants(currentPage, sortBy)
            fillTableRestaurants(data, tableBody, currentPage)
            addToggleDeleteListeners()
        })

        lastPageBtn.addEventListener('click', async (e) => {
            e.preventDefault()
            currentPage = Math.ceil(totalRestaurants[0] / 15)
            tableBody.innerHTML = ''
            currentPageElement.innerHTML = currentPage
            const data = await getRestaurants(currentPage, sortBy)
            fillTableRestaurants(data, tableBody)
            addToggleDeleteListeners()
        })

        const updatePagination = async (gap) => {
            currentPage = currentPage + gap
            if (currentPage < 1) {
                currentPage = 1
            }
            tableBody.innerHTML = ''
            const data = await getRestaurants(currentPage, sortBy)
            currentPageElement.innerHTML = currentPage
            fillTableRestaurants(data, tableBody, currentPage)
            addToggleDeleteListeners()
        }
    })
</script>