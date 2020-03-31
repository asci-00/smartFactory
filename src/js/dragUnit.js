class DragProc {
    static nowDrag = ''
    static apply = true
    static match = {
        'trigger' : ['sensor'],
        'action' : ['actuator']
    }
    static init() {  
        let originImg = document.getElementsByClassName('unit-img')
        for(var idx = 0; idx < originImg.length; idx++) {
            originImg[idx].addEventListener("dragstart", DragProc.dragstart)
            originImg[idx].addEventListener("dragend", DragProc.dragend)
        }
        const containers = document.getElementsByClassName('unit-box')
        for(var idx = 0; idx < containers.length; idx++) {
            containers[idx].addEventListener("dragover", DragProc.dragover)
            containers[idx].addEventListener("dragenter", DragProc.dragenter)
            containers[idx].addEventListener("dragleave", DragProc.dragleave)
            containers[idx].addEventListener("drop", DragProc.drop)
        }
    }
    static dragstart = e => this.nowDrag=e.target.id
    static dragover = e => e.preventDefault()
    static dragenter = e => {
        var box = e.target.id.includes('box') ? e.target : e.target.parentNode
        var targetType = this.getType(this.nowDrag)
        var aclass=''
        if(this.match[this.getType(box.id)].includes(targetType)) {
            this.apply = true
            aclass=' apply-pass'
        } else {
            this.apply = false
            aclass=' apply-fail'
        }
        box.className += aclass
    }  
    static dragleave = e => {
        var box = e.target.id.includes('box') ? e.target : e.target.parentNode
        box.className = 'wt-box unit-box'
    }
    static drop = e => {
        var box = e.target.id.includes('box') ? e.target : e.target.parentNode
        var id = this.nowDrag
        box.className = 'wt-box unit-box'
        if(!this.apply) return

        var obj = document.getElementById(id).cloneNode(true)
        this.applyUnit(obj, box)
    }
    static applyUnit = (obj, box) => {
        box.innerHTML = ''

        obj.id = `${this.getType(box.id)}-${this.getName(obj.id)}`

        obj.addEventListener('dragstart', DragProc.dragstart)
        obj.addEventListener("click", DragProc.appliedClick)
        box.appendChild(obj)

        ConfigBox.remove(this.getType(box.id))
        ConfigBox.hide()
        new ConfigBox(
            this.getName(this.nowDrag).replace(/[0-9]/g, ''), 
            this.getType(box.id))
            .SetConfig()
        
        var form = document.getElementById('work-setting')
        var name = this.getName(obj.id)

        this.getType(box.id) == 'trigger' ? 
            (form.trigger.value = name) : 
            (form.actuator.value = name)
    }
    static appliedClick = e => {
        ConfigBox.hide()
        ConfigBox.show(`${this.getType(e.target.id)}-config`)
    }
    static getType = str => str.split('-')[0]
    static getName = str => str.split('-')[1]
}
window.onload = () => DragProc.init() 