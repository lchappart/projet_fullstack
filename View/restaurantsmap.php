<div class="d-flex justify-content-center">
    <div class="spinner-border text-primary" id="spinner" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div class="row mt-5">
    <div class="col" id="map-container">

    </div>
</div>
<script type="module" src="./Assets/JS/services/restaurantsmap.js"></script>
<script type="module">
    import {getAllRestaurants} from "./Assets/JS/services/restaurantsmap.js";
    import {getCoordinates} from "./Assets/JS/services/restaurantsmap.js";

    document.addEventListener('DOMContentLoaded', async () => {
        const spinner = document.querySelector('#spinner')
        const mapContainer = document.querySelector('#map-container')
        const data = await getAllRestaurants()
        const coordinates = []
        for (let i = 0; i < data.length; i++) {
            coordinates.push(await getCoordinates(data[i].address))
        }
        mapContainer.innerHTML = '<div id="map"></div>'
        let map = L.map('map').setView([48.8566, 2.3522], 7)
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map)
        const mapElement = document.querySelector('#map')
        mapElement.style.height = '600px'
        mapElement.style.width = '100%'
        map.invalidateSize()
        for (let i = 0; i < coordinates.length; i++) {
            let marker = L.marker([coordinates[i].features[0].geometry.coordinates[1], coordinates[i].features[0].geometry.coordinates[0]]).addTo(map)
            marker.bindPopup(`<ol class="list-group list-group-numbered">
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                  <div class="fw-bold">Manager</div>
                                    ${data[i].manager}
                                </div>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                  <div class="fw-bold">Nombre Siret-Siren</div>
                                  ${data[i].siret_siren}
                                </div>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                  <div class="fw-bold">Adresse</div>
                                  ${data[i].address}
                                </div>
                              </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                  <div class="fw-bold">Horaires d'ouvertures</div>
                                  ${data[i].opening_hours}
                                </div>
                              </li>
                            </ol>
                            <a href="index.php?component=restaurant&action=edit&id=${data[i].id}">
                                <i class="fa-solid fa-pen mt-2"></i>
                            </a>
`)
            marker.addEventListener('click', (e) => {
                e.preventDefault()
                marker.openPopup()
            })
        }
        spinner.classList.add('d-none')
    })
</script>