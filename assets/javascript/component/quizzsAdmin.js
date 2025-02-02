import {deletteQuizz, getQuizzsAdmin, updateIsPublishedQuizz} from "../services/quizzAdmin.js";
import {showToast} from "./shared/toast.js";

export const handleSortBy = (page, sortBy) => {
    const sortItem = document.querySelectorAll('.sort-by-item')

    for (let i = 0; i < sortItem.length; i++) {
        sortItem[i].addEventListener('click', async (event) => {
            sortBy = event.target.getAttribute('data-sort-by')
            event.target.setAttribute('data-sort-by', (sortBy.includes("ASC") ? sortBy.substring(0, sortBy.length - 3) + "DESC" : sortBy.substring(0, sortBy.length - 4) + "ASC"))
            await displayQuizzs(page, sortBy)
        })
    }
}

export const displayQuizzs = async (page, sortBy) => {
    const spinner = document.querySelector("#spinner")
    const listElement = document.querySelector("#list-quizzs")

    spinner.classList.remove('d-none')

    let data = await getQuizzsAdmin(page, sortBy)
    const listContent = []

    for (let i = 0; i < data.quizzs.length; i++) {
        listContent.push(getRow(data.quizzs[i]))
    }

    listElement.querySelector('tbody').innerHTML = listContent.join('')

    document.querySelector('#pagination').innerHTML = getPagination(data.quizzCount.idCount)

    handlePaginationNavigation(page, sortBy)
    handlePublishedClick(page, sortBy)
    handleDeleteClick(page, sortBy)
    handleUpdateClick()

    spinner.classList.add('d-none')
}

export const handlePaginationNavigation = (page, sortBy) => {
    const previousPage = document.querySelector('#prev-page')
    const nextPage = document.querySelector('#next-page')
    const paginationBtns = document.querySelectorAll('.change-page')

    previousPage.addEventListener('click', async () => {

        if (page > 1) {
            page--
            await displayQuizzs(page, sortBy)
        }

    })

    for (let i = 0; i < paginationBtns.length; i++) {
        paginationBtns[i].addEventListener('click', async (e) => {
            const pageNumber = e.target.getAttribute('data-page')
            await displayQuizzs(pageNumber, sortBy)
        })
    }

    nextPage.addEventListener('click', async () => {
        page++

        await displayQuizzs(page, sortBy)
    })
}

export const getPagination = (total, page) => {
    let maxPage = Math.ceil(total / 15)
    let paginationButton = []

    paginationButton.push(
        `<li id="prev-page" class="page-item" ${page <= 1 ? "disable" : ""}>
            <a class="page-link">Previous</a>
         </li>`)

    for (let i = 1; i <= maxPage; i++) {
        paginationButton.push(`<li class="page-item"><a data-page='${i}' class="page-item page-link change-page" href="#">${i}</a></li>`)
    }

    paginationButton.push(
        `<li id="next-page" class="page-item" ${page >= maxPage ? "disable" : ""}>
            <a class="page-link" href="#">Next</a>
         </li>`)

    return paginationButton.join('')
}

export const getRow = (quizz) => {
    return `
            <tr>
                <th scope="row">${quizz.id}</th>
                <td style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; min-width: 300px; max-width: 500px;">${quizz.name}</td>
                <td><a href="#">
                    <i class="btn-published ${quizz.is_published === 0 ?
                                            "fa-regular fa-eye text-success" :
                                            "fa-regular fa-eye-slash text-danger"}" 
                       data-id=${quizz.id}></i>
                    </a>
                    <div class="spinner-border spinner-border-sm d-none" role="status" id="published-spinner-${quizz.id}">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-outline-danger btn-delete" data-id=${quizz.id}>Supprimer</button>
                    <div class="spinner-border spinner-border-sm d-none" role="status" id="delete-spinner-${quizz.id}">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </td>
                <td>
                    <button type="button" class="btn btn-primary update-btn" data-id=${quizz.id}>Modifier</button>
                </td>
            </tr>
    `
}

export const handlePublishedClick = (page, sortBy) => {
    const btnPublishedElement = document.querySelectorAll(".btn-published")

    for (let i = 0; i < btnPublishedElement.length; i++) {
        btnPublishedElement[i].addEventListener('click', async (e) => {
            const id = e.target.getAttribute('data-id')
            const spinner = document.querySelector(`#published-spinner-${id}`)
            spinner.classList.remove('d-none')
            const result = await updateIsPublishedQuizz(page, sortBy, id)

            if (result.hasOwnProperty('success')) {

                if (e.target.classList.contains('fa-check')) {
                    e.target.classList.remove('fa-check', 'text-success')
                    e.target.classList.add('fa-xmark', 'text-danger')
                } else {
                    e.target.classList.add('fa-check', 'text-success')
                    e.target.classList.remove('fa-xmark', 'text-danger')
                }

                showToast('La publication du quizz a été modifé avec succès', 'bg-success')
            } else {
                showToast(result.error, 'bg-danger')
            }

            spinner.classList.add('d-none')
            await displayQuizzs(page, sortBy)
        })
    }
}

export const handleDeleteClick = (page, sortBy) => {
    const btnPublishedElement = document.querySelectorAll(".btn-delete")

    for (let i = 0; i < btnPublishedElement.length; i++) {
        btnPublishedElement[i].addEventListener('click', async (e) => {
            const id = e.target.getAttribute('data-id')
            const spinner = document.querySelector(`#delete-spinner-${id}`)

            if (confirm(`Etes-vous sûr de vouloir supprimer le quizz n°${id}`)) {
                spinner.classList.remove('d-none')
                const result = await deletteQuizz(page, sortBy, id)

                if (result.hasOwnProperty('success')) {
                    showToast('Le quizz été supprimé avec succès', 'bg-success')
                } else {
                    showToast(result.error, 'bg-danger')
                }

                spinner.classList.add('d-none')

                await displayQuizzs(page, sortBy)
            }

        })
    }
}

export const handleUpdateClick = () => {
    const updateBtns = document.querySelectorAll(".update-btn")

    for (let i = 0; i < updateBtns.length; i++) {
        updateBtns[i].addEventListener('click', (e) => {
            document.location.href = `index.php?component=quizzAdmin&action=update&id=${e.target.getAttribute('data-id')}`
        })
    }
}
