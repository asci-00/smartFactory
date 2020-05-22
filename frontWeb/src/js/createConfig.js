setAttributes = (el, attrs) => {
    for(var key in attrs) {
        el.setAttribute(key, attrs[key]);
    }
}
class Toggle {
    constructor(onmsg, offmsg, obj) {
        [this.onMsg, this.offMsg, this.targetOBJ, this.state] = [onmsg, offmsg, obj, false]
        this.value = offmsg
        this.targetOBJ.value = this.value
    }
    onclick = e => {
        this.setState(e, this.state)
        this.state = !this.state
    }
    setState = (e, state) => {
        var msg = state ? this.offMsg : this.onMsg
        e.target.innerHTML = this.targetOBJ.value = msg
    }
}
const logicApplyBox = () => {
    const dragBox = document.createElement('div')
    dragBox.id='logic-box'
    dragBox.classList.add('wt-box')
    dragBox.classList.add('unit-box')
    dragBox.classList.add('move-ani')
    dragBox.style.margin="10px auto"
    dragBox.style.float="none"

    const innerText = document.createElement('span')
    innerText.innerHTML='CLICK'
    dragBox.appendChild(innerText)

    return dragBox
}
const logicApply = obj => {    
    const box = document.getElementById('logic-box')
    const logicType = document.querySelector('[name=logic_type]')
    applyData(obj, box) //unit apply

    box.classList.add('left-move')  //box left move

    const logicConfig = document.createElement('div') //create logic config box
    logicConfig.id = 'logic-config'
    const id = obj.id.split('-')
    const name = `${id[1]}-${id[2]}`
    logicType.value = name
    setAttributes(logicConfig, {'title' : name})
    
    const unit = unit_info[name]
    const columns = Object.keys(unit).length

    const width = (100 / columns) - columns
    
    const innerConfig = document.createElement('div')
    innerConfig.classList.add('logic-inner-config')
    innerConfig.style.width=`${width}%`
    /*type에 따른 처리 필요 - 지금은 file만*/

    for(var text in unit) {
        const dConfig = innerConfig.cloneNode(true)
        const title = document.createElement('div')
        title.innerHTML = text
        title.classList.add('config-title')

        dConfig.appendChild(title)

        for(var input in unit[text]) {
            const set = document.createElement('label') //input으로 change
            const file = document.createElement('input')

            setAttributes(set, {
                'for' : text+input, 
                'class' : 'wt-box unit-box logic-unit',
            })
            setAttributes(file, {
                'id' : text+input,
                'name' : `${text}[${input}]`,
                'type' : 'file',
                'accept' : 'image/*',
                'onChange' : 'loadFile(event)'
            })
            file.style.display='none'

            dConfig.appendChild(file)
            dConfig.appendChild(set)
        }
        logicConfig.appendChild(dConfig)
    }

    return logicConfig
}

class ConfigBox {
    constructor(name, type) {
        this.name = name
        this.type = type
        this.info = unit_info[name]
        this.logic = false
    }
    SetConfig = () => {
        var ObjList = []
        var container = document.getElementById(`${this.type}-config`)

        for (var input in this.info) {
            var [type, value] = [input, this.info[input][0]]
            switch(input) {
                case 'checkbox':
                    var _type = (this.type == 'trigger') ? 'value' : 'action'
                    ObjList.push(this.CreateInput(input, `vir-${_type}`))
                    var hiddenContent = this.CreateInput('hidden', _type, this.info[input][1])
                    ObjList.push(this.setLabel(input, `vir-${_type}`, this.info[input], hiddenContent))
                    ObjList.push(hiddenContent)
                    break
                case 'radio':
                    var name = (this.type == 'trigger') ? 'operator' : 'action'
                    for(var key in this.info[input]) {
                        var value = this.info[input][key]
                        ObjList.push(this.CreateInput(type, name, value, key))
                        ObjList.push(this.setLabel(type, name+key, value))
                    }
                    break
                case 'number':
                    ObjList.push(this.CreateInput(type, 'value', value, key))
                    break
                case 'object':
                    const obj = logicApplyBox()
                    ObjList.push(obj)
                    this.logic = true
                    break
            }
        }
        ObjList.map(input => container.appendChild(input))
        if(this.logic) modalInit('logic-box')
        this.logic = false
        ConfigBox.show(`${this.type}-config`)
    }
    CreateInput = (type, name, value = 0, key = '') => {
        var input = document.createElement('input')
        type == 'number' ? setAttributes(input, {'placeholder' : value}) : setAttributes(input, {'value' : value})
        setAttributes(input, {'type' : type, 'name' : name, 'id' : name+key})
        return input
    }
    setLabel = (type, For, value, obj = null) => {
        var label = document.createElement('label')
        switch(type) {
            case 'checkbox':
                var toggle = new Toggle(value[0], value[1], obj)
                setAttributes(label, {'for' : For, 'class' : 'btn btn-primary'})
                label.addEventListener('click', toggle.onclick)
                label.innerHTML = value[1]
                break
            case 'radio':
                setAttributes(label, {'for' : For, 'class' : 'btn btn-danger'})
                label.innerHTML = value
                break
        }
        return label
    }
    static hide = (name = null) => {
        if(name == null) {
            this.hide('trigger-config')
            this.hide('action-config')
        }
        else document.getElementById(name).style.display = 'none'
    }
    static show = name =>
        document.getElementById(name).style.display = 'block'
    static remove = name =>
        document.getElementById(`${name}-config`).innerHTML = ''
    static setConfig = (type, name, fType, value, query=false) => {
        switch(fType) {
            case 'checkbox':
                if(value == 0) {
                    query ?
                        document.querySelector(`[for=vir-action]`).click():
                        document.getElementById(`${type}-label`).click()
                }
                break
            case 'radio':
                document.getElementsByName(name)[value].checked=true
                break
            case 'number':
                document.getElementsByName(name)[0].value = value
                break
        }
    }
}