export const showToast = (message, color) => {
    const toastElement = document.querySelector('#toast')
    const toast = new bootstrap.Toast(toastElement, {
        delay: 5000
    })
    //reinitialisation des couleurs
    toastElement.classList.remove('bg-danger','bg-success')
    //ajout de ma couleur
    toastElement.classList.add(color)

    toastElement.querySelector('.toast-body').innerHTML = message

    toast.show()

}