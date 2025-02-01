import {formatTime} from "./shared/timer.js";


export const getCard = (quizz) => {
    const isTime = quizz.best_time !== null

return `
        <div class="card m-3" style="width: 18rem;">
            <div class="card-body d-flex flex-column justify-content-between">
                <h5 class="card-title">${quizz.name}</h5>
                <div class="mt-2">
                ${isTime ? `
                            <p class="lh-1"><strong>Meilleur temps :</strong> ${formatTime(quizz.best_time)}</p>
                            <p class="lh-1"><strong>Temps Moyen :</strong> ${formatTime(quizz.average_time)}</p>
                            `
                        :                   
                            `<p>${parseInt(quizz.is_chrono) === 0 ? 
                                "Pas de données de temps" : 
                                "Pas de chrono pour ce quizz"}
                            </p>`}
                    <div class="d-flex justify-content-center">
                        <button data-id=${quizz.id} class="btn btn-primary go-btn center-item">Commencer</button>
                    </div>
                </div>
            </div>
        </div>
    `
}