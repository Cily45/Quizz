export const showToast = (message, color) => {
    const toastElement = document.querySelector('#toast')

    const toast = new bootstrap.Toast(toastElement, {
        delay: 5000
    })

    toastElement.classList.remove('bg-danger', 'bg-success')
    toastElement.classList.add(color)

    toastElement.querySelector('.toast-body').innerHTML = message

    toast.show()
}