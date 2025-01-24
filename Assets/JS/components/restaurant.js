import {getAddresses} from "../services/restaurant.js";

export const addAddressListeners = (addressInput, modal) => {

    const searchAddressBtnElement = document.querySelector('#search-address-btn')
    const addressElement = document.querySelector('#search-address')

    addressElement.addEventListener('change', async () => {
        if (addressElement.value === '') {
            searchAddressBtnElement.disabled = true
        }
        else {
            searchAddressBtnElement.disabled = false
        }
    })

    searchAddressBtnElement.addEventListener('click', async () => {
        const addressContent = addressElement.value
        const data = await getAddresses(addressContent)
        const addresses = []
        for (let i = 0; i < data.features.length; i++) {
            addresses.push(`<li class="list-group-item"><a href="#" style="text-decoration: none; color: black;" data-address-id="${data.features[i].properties.label}">${data.features[i].properties.label}</a></li>`)
        }
        const modalBody = `<div><ul class="list-group">${addresses.join('')}</ul></div>`
        document.querySelector('.modal-body').innerHTML = modalBody
        document.querySelector('.modal-title').innerHTML = 'Choix de l\'adresse'
        const validBtnElement = document.querySelector('.modal-footer').querySelector('.btn-success')
        if (validBtnElement) {
            validBtnElement.remove()
        }
        const addressesLinkElements = document.querySelectorAll('.list-group-item a')
        const addressInput = document.querySelector('#address')
        for (let i = 0; i < addressesLinkElements.length; i++) {
            addressesLinkElements[i].addEventListener('click', (event) => {
                const clickedAddressId = event.target.getAttribute('data-address-id')
                const clickedAddress = data.features.find(feature => feature.properties.label === clickedAddressId)
                const clickedAddressCoordinates = clickedAddress.geometry.coordinates
                addressInput.value = clickedAddress.properties.label
                modal.hide()
                let map = L.map('map').setView([clickedAddressCoordinates[1], clickedAddressCoordinates[0]], 7)
                console.log(2)
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map)
                const mapElement = document.querySelector('#map')
                mapElement.style.height = '150px'
                mapElement.style.width = '150px'
                map.invalidateSize()
                let marker = L.marker([clickedAddressCoordinates[1], clickedAddressCoordinates[0]]).addTo(map)

            })
        }
        modal.show()
    })
}