onClick = e => {
    var form = document.getElementById('work-setting')
    if (typeof(form.trigger) == 'undefined' || form.trigger.value == "" ||
        typeof(form.value) == 'undefined' || form.value.value == "" ||
        typeof(form.actuator) == 'undefined' || form.actuator.value == "" ||
        typeof(form.action) == 'undefined' || form.action.value == ""
    ) {
        alert('you missing require input');
        return false
    }
    if (typeof(form.operator) == 'undefined' || form.operator.value == "") {
        operator = document.createElement('input')
        setAttributes(operator, {'type' : 'hidden', 'name' : 'operator', 'value' : '='})
        form.appendChild(operator)
    }
    console.log(`INSERT INTO 'work' ('operator', 'value', 'action')  
    VALUES ('${form.operator.value}', '${form.value.value}', '${form.action.value}');`)
    form.submit()
}