const alerta = document.querySelector('.alerta');
const primeraValidacionInpt = document.querySelector('#primeraValidacion').value;
const segundaValidacionInpt = document.querySelector('#segundaValidacion').value;


document.addEventListener('DOMContentLoaded', () => {
    setTimeout( () => {
        alerta.remove()
    }, 3000);

   /* if( primeraValidacionInpt.equals("SI") ) {
        console.log(segundaValidacionInpt)
        segundaValidacionInpt.removeAttribute("disabled");
    }

    if( segundaValidacionInpt.equals("") ) {
        primeraValidacionInpt.setAttribute("disabled")
    }
    
    console.log( primeraValidacionInpt, segundaValidacionInpt );*/
});