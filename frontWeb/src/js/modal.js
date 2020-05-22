let modalArea, openModal, modalBg

const modalInit = buttonStr => {
    openModal = document.getElementById(buttonStr)
    modalBg = document.getElementById('modalBg')
    modalArea = document.getElementById('modalArea')
    const toggle = [openModal,modalBg]
    for(let i=0, len=toggle.length ; i<len ; i++){
        toggle[i].addEventListener('click',function(e){
            modalArea.classList.toggle('is-show')
        },false)
    }
}
const modalUnitClick = e => {
    const container = document.getElementById('trigger-config')
    const exist = document.getElementById('logic-config')
    if(exist != null ) container.removeChild(exist)
    const logicConfig = logicApply(e.target.cloneNode(true))
    container.appendChild(logicConfig)

    modalArea.classList.toggle('is-show')
}