function deleteEmail(id, contato) {
    if (confirm('Você quer mesmo deletar esse email?')) {
        document.location.href = '?deleteEmail='+id + '&id=' + contato;
    }
}

function deleteTelefone(id, contato) {
    if (confirm('Você quer mesmo deletar esse telefone?')) {
        document.location.href = '?deleteTelefone='+id + '&id=' + contato;
    }
}

function deleteContact(id) {
    if (confirm('Você quer mesmo deletar esse contato?')) {
        document.location = 'delete.php?id='+id;
    }
}