

export const GetRow = (quizz) => {
    const body =`<tr>
            <th scope="row">${quizz.id}</th>
            <td>${quizz.name}</td>
        </tr>`

    return body;
}