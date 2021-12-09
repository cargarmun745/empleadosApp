$('#modalDelete').on('shown.bs.modal', function (event) {
    let deletePuesto = document.getElementById('deletePuesto');
    let element = event.relatedTarget;
    console.log(element);
    let action = element.getAttribute('data-url');
    let name = element.getAttribute('data-name');
    deletePuesto.innerHTML = name;
    let form = document.getElementById('modalDeletePuestoForm');
    form.action = action;
    
})