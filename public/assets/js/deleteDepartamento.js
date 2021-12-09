$('#modalDelete').on('shown.bs.modal', function (event) {
    let deleteDepartamento = document.getElementById('deleteDepartamento');
    console.log(deleteDepartamento);
    let element = event.relatedTarget;
    console.log(element);
    let action = element.getAttribute('data-url');
    let name = element.getAttribute('data-name');
    console.log(name)
    deleteDepartamento.innerHTML = name;
    let form = document.getElementById('modalDeleteDepartamentoForm');
    form.action = action;
    
})