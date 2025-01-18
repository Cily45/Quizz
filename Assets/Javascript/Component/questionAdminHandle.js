

export const handleAccordion = () =>{
    const accordionItems = document.querySelectorAll('.accordion-item')
    let dragStartClientY
    let draggedItem

    const addBorder = (target) => {
        if(target !== draggedItem){
            target.classList.add('border', 'border-2', 'border-primary')
        }
    }

    const removeBorder = (target) => {
        if(target !== draggedItem){
            target.classList.remove('border', 'border-2', 'border-primary')
        }
    }
    const handleDragStart = (e) => {
        const target = e.target

        target.style.opacity = 0.5

        draggedItem = target
        dragStartClientY = e.clientY
    }
    const handleDragEnter = (e) => {
        addBorder(e.target)
    }
    const handleDragLeave = (e) => {
        removeBorder(e.target)
    }
    const handleDragEnd = (e) => {
        const target = e.target
        target.style.opacity = 1
        removeBorder()


    }
    const handleDrop = (e) => {
        const target = e.target.closest('.accordion-item')
        if(dragStartClientY >e.clientY){
            target.parentNode.insertBefore(draggedItem, target.previousSibling)
        }else{
            target.parentNode.insertBefore(draggedItem, target.nextSibling)

        }
        removeBorder(target)

        draggedItem = null
    }
    const handleDragOver = (e) => {
        e.preventDefault()

    }

    for (let i = 0; i < accordionItems.length; i++){
        accordionItems[i].addEventListener('dragstart', handleDragStart)
        accordionItems[i].addEventListener('dragenter', handleDragEnter)
        accordionItems[i].addEventListener('dragleave', handleDragLeave)
        accordionItems[i].addEventListener('dragover', handleDragOver)
        accordionItems[i].addEventListener('dragend', handleDragEnd)

        accordionItems[i].addEventListener('drop', handleDrop)
    }
}
