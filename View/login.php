<div id="error">

</div>
<form id="login-form">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" aria-describedby="emailHelp" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" required>
    </div>
    <button type="button" id="login-btn" class="btn btn-primary">Soumettre</button>
</form>
<script type="module" src="Assets/services/login.js"></script>
<script type="module">
    import {login} from "./Assets/services/login.js";
    document.addEventListener("DOMContentLoaded",  () => {
        const form = document.querySelector("#login-form")
        const loginButton = document.querySelector("#login-btn")
        loginButton.addEventListener("click", async() => {
            if (!form.checkValidity()) {
                form.reportValidity()
                return false
            }
            const loginResult = await login(form.elements['username'].value, form.elements['password'].value)
            if (loginResult.hasOwnProperty('authentication')){
                document.location.href = 'index.php?component=users'
            }
            const errorDiv = document.querySelector('#error')
            if (loginResult.hasOwnProperty('errors')){
                const errors = []
                for (let i = 0; i < loginResult.errors.length; i++) {
                    errors.push(`<div class="alert alert-danger" role="alert">${loginResult.errors[i]}</div>`)
                }

                errorDiv.innerHTML = errors.join('')
            }

        })
    })
</script>
