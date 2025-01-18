<div id="errors">

</div>
<form id="login-form">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" required>
    </div>
    <button type="button" id="login-btn" class="btn btn-primary">Valider</button>
</form>

<script src="./Assets/JavaScript/Services/login.js" type="module"></script>
<script type="module">
    import {login} from "./Assets/JavaScript/Services/login.js";

    document.addEventListener('DOMContentLoaded', () => {
        const validLoginBtn = document.querySelector('#login-btn')

        validLoginBtn.addEventListener('click', async () => {
            const formLogin = document.querySelector('#login-form')
            if (!formLogin.checkValidity()){
                formLogin.reportValidity()
                return false
            }
            const loginResult = await login(formLogin.elements['username'].value, formLogin.elements['password'].value)

            if (loginResult.hasOwnProperty('authentication')){
                document.location.href = 'index.php?component=quizzsAdmin'
            } else if (loginResult.hasOwnProperty('errors')){
                const errorsLogsElement = document.querySelector('#errors')
                errorsLogsElement.innerHTML = `
                    <div class="alert alert-danger mt-2" role="alert">
                      ${loginResult.errors.toString()}
                    </div>
                    `
            }
        })
    })
</script>