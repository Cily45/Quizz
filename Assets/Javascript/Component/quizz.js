

export const getCard = (quizz) => {
    return `
    <div class="card m-3" style="width: 18rem;">
  <img src="https://cdn.futura-sciences.com/cdn-cgi/image/width=1920,quality=60,format=auto/sources/images/dossier/rte/9115_livre%20ouvert_Horia%20Varlan%20-flickr%20by%2020.jpg" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">${quizz.name}</h5>
    <button data-id=${quizz.id} class="btn btn-primary go-btn">Commencer</button>
  </div>
</div>
    `
}