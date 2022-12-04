const alerta = document.querySelector('.alerta');
console.log(alerta)

document.addEventListener('DOMContentLoaded', () => {
    setTimeout( () => {
        alerta.remove()
    }, 3000)
})