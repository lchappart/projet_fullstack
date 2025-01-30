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
    import {getDepartementsData} from "./Assets/JS/services/restaurantsmap.js";

    document.addEventListener('DOMContentLoaded', async () => {
        let customIcon
        const spinner = document.querySelector('#spinner')
        const mapContainer = document.querySelector('#map-container')
        const departementsData = await getDepartementsData()
        const data = await getAllRestaurants()
        const coordinates = []
        for (let i = 0; i < data.restaurants.length; i++) {
            coordinates.push(await getCoordinates(data.restaurants[i].address))
        }
        mapContainer.innerHTML = '<div id="map"></div>'
        let map = L.map('map').setView([46.8566, 2.10], 6)
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map)
        const mapElement = document.querySelector('#map')
        mapElement.style.height = '600px'
        mapElement.style.width = '100%'
        map.invalidateSize()
        let src =''
        let geojsonLayer

        let markers = L.markerClusterGroup({
            spiderfyOnMaxZoom: false,
            showCoverageOnHover: false,
            zoomToBoundsOnClick: false
        });

        const highlightFeature = (e) => {
            const layer = e.target
            layer.setStyle({
                fillColor: 'blue',
                weight: 3,
                fillOpacity: 0.7
            })
        }


        const resetHighlight = (e) => {
            geojsonLayer.resetStyle(e.target)
        }

        function zoomToFeature(e) {
            map.fitBounds(e.target.getBounds())
        }



        geojsonLayer = L.geoJSON(departementsData, {
            style: {
                weight: 2,
                color: 'black',
                dashArray: '3',
            },
            onEachFeature: (feature, layer) => {
                layer.on({
                    mouseover: highlightFeature,
                    mouseout: resetHighlight,
                    click: zoomToFeature
                })
            }
        }).addTo(map)
        for (let i = 0; i < coordinates.length; i++) {
            src = '/projet_fullstack/uploads/'
            if (data.restaurants[i].image === '')
            {
                src += 'default.jpg'
            }
            else
            {
                src += data.restaurants[i].image
            }
            customIcon = L.icon({
                iconUrl: `./Includes/Img/marker${data.restaurants[i].group_id}.png`,
                iconSize: [38, 38],
                iconAnchor: [16, 38],
                popupAnchor: [0, -38]
            });
            let marker = L.marker([coordinates[i].features[0].geometry.coordinates[1], coordinates[i].features[0].geometry.coordinates[0]], {icon:customIcon})
            marker.bindPopup(`<img src="${src}" height="100px">
                              <ol class="list-group list-group-numbered">
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                  <div class="fw-bold">Manager</div>
                                    ${data.restaurants[i].manager}
                                </div>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                  <div class="fw-bold">Nombre Siret-Siren</div>
                                  ${data.restaurants[i].siret_siren}
                                </div>
                              </li>
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                  <div class="fw-bold">Adresse</div>
                                  ${data.restaurants[i].address}
                                </div>
                              </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                  <div class="fw-bold">Horaires d'ouvertures</div>
                                  ${data.restaurants[i].opening_hours}
                                </div>
                              </li>
                               <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                  <div class="fw-bold">Groupe</div>
                                  ${data.groups[data.restaurants[i].group_id - 1].name}
                                </div>
                              </li>
                            </ol>
                            <a href="index.php?component=restaurant&action=edit&id=${data.restaurants[i].id}">
                                <i class="fa-solid fa-pen mt-2"></i>
                            </a>
`)
            marker.addEventListener('click', (e) => {
                marker.openPopup()
            })
            markers.addLayer(marker)
        }
        map.addLayer(markers)
        spinner.classList.add('d-none')
    })
</script>