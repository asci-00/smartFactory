onClick = e => {
    var form = document.getElementById('work-setting')
    if (!checkavail(form.trigger) || !checkavail(form.value) || 
        !checkavail(form.actuator) || !checkavail(form.action)) {
        if(!checkavail(form.logic_type)) {
            alert('you missing require input')
            return false
        }
        const value = document.createElement('input')
        setAttributes(value, {
            'type' : 'hidden', 
            'name' : 'value', 
            'value' : form.logic_type.value
        })
        form.appendChild(value)
        console.log(form)
    }
    if (typeof(form.operator) == 'undefined' || form.operator.value == "") {
        const operator = document.createElement('input')
        setAttributes(operator, {
            'type' : 'hidden', 
            'name' : 'operator', 
            'value' : '='
        })
        form.appendChild(operator)
    }
    form.submit()
}

const checkavail = obj => !(typeof(obj) == 'undefined' || obj.value == "")