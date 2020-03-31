setAttributes = (el, attrs) => {
    for(var key in attrs) {
        el.setAttribute(key, attrs[key]);
    }
}
class Toggle {
    constructor(onmsg, offmsg, obj) {
        [this.onMsg, this.offMsg, this.targetOBJ, this.state] = [onmsg, offmsg, obj, false]
        this.value = offmsg
        console.log(this.targetOBJ)
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

class ConfigBox {
    constructor(name, type) {
        this.name = name
        this.type = type
        this.info = unit_info[name]
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
            }
        }
        ObjList.map(input => container.appendChild(input))
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
}