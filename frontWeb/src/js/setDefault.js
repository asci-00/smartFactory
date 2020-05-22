const init = data => {
    if(data == 0) return
    var {trigger, operator, value, actuator, action} = data
    triggerImg = document.getElementById(`sensor-${trigger}`) //if trigger type is various check the first-string
    DragProc.applyUnit(triggerImg.cloneNode(true), document.getElementById('trigger-box'))
    actionImg = document.getElementById(`actuator-${actuator}`)
    DragProc.applyUnit(actionImg.cloneNode(true), document.getElementById('action-box'))
    
    for(var input in unit_info[trigger]) {
        var unit_value = unit_info[trigger];
        switch (input) {
            case 'checkbox':
                ConfigBox.setConfig('trigger', 'value', input, unit_value[input].indexOf(value))
                break
            case 'radio':
                ConfigBox.setConfig('trigger', 'operator', input, unit_value[input].indexOf(operator))
                break
            case 'number':
                ConfigBox.setConfig('trigger', 'value', input, value)
                break
        }
    }
    var actuator_type = actuator.replace(/[0-9]/g, '')
    for(var input in unit_info[actuator_type]) {
        console.log(actuator_type, '=>',  unit_info[actuator_type])
        ConfigBox.setConfig('action', 'action', input,
                            unit_info[actuator_type][input].indexOf(action), true)
    }
}