export const getRow = (quizz) => {
    return `
            <tr>
            <th scope="row">${quizz.id}</th>
            <td>${quizz.name}</td>
            </tr>
`
}