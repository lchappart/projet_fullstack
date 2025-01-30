<?php
/**
 * @var string $action
 * @var array $restaurant
 */
?>


<div class="row">
    <div class="col">
        <div class="h1 pt-2 pb-2 text-center">Créer / Modifier un restaurant</div>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input required class="form-control" name="image" type="file" id="image">
            </div>
            <div class="mb-3">
                <label for="manager" class="form-label">Manager</label>
                <input type="text" class="form-control" id="manager" name="manager" value="<?php  echo $restaurant['manager'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="siret-siren" class="form-label">Siret Siren</label>
                <input type="text" class="form-control" id="siret-siren" name="siret-siren" value="<?php  echo $restaurant['siret_siren'] ?? ''; ?>" <?php  echo ('create' === $action) ? 'required' : ''; ?>>
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col-11">
                        <div class="mb-3">
                            <input
                                    type="text"
                                    class="form-control"
                                    id="search-address"
                                    placeholder="Veuillez saisir une adresse pour lancer la recherche"
                            />
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="mb-3">
                            <button
                                    class="btn btn-primary"
                                    id="search-address-btn"
                                    type="button"
                                    disabled
                            >
                                OK
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="address" class="form-label">Adresse</label>
                            <textarea class="form-control" id="address" name="address" required><?php echo isset($restaurant['address']) ? $restaurant['address'] : ''; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div id="map"></div>
            <div class="mb-3">
                <label for="opening-hours" class="form-label">Horaires d'ouverture</label>
                <input type="text" class="form-control" id="opening-hours" name="opening-hours" value="<?php  echo $restaurant['opening_hours'] ?? ''; ?>" <?php  echo ('create' === $action) ? 'required' : ''; ?> >
            </div>
            <select id="group-dropdown" name="group" class="form-select" data-group="<?php echo $restaurant['group_id'] ?? '' ?>" aria-label="Default select example" required>
                <option disabled value="" <?php echo ($action === 'create') ? 'selected' : '';?> >Selectionnez un groupe</option>
            </select>
            <div class="mb-3 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" name="<?php echo $action; ?>_button">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" tabindex="-1" id="modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="modal-valid-btn">Valider et réinitialiser</button>
            </div>
        </div>
    </div>
</div>
<script type="module">

    import {addAddressListeners} from "./Assets/JS/components/restaurant.js";
    import {getGroups} from "./Assets/JS/services/restaurant.js";

    document.addEventListener('DOMContentLoaded', async () => {
        const modalElement = document.querySelector('#modal')
        const modal = new bootstrap.Modal(modalElement, {backdrop:   'static'})
        const addressInput = document.querySelector('#address')
        const mapElement = document.querySelector('#map')
        const dropdownMenu = document.querySelector('#group-dropdown')
        const groupId = dropdownMenu.getAttribute('data-group')
        const groups = await getGroups()
        for (let i = 0; i < groups.length; i++) {
            const option = document.createElement('option')
            option.value = groups[i].id
            option.innerHTML = groups[i].name
            if (groups[i].id == groupId) {
                option.selected = true
            }
            dropdownMenu.appendChild(option)
        }
        addAddressListeners(addressInput, modal, mapElement)
    })
</script>