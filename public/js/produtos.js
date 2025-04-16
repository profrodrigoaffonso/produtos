// formata valor (#.###,##)
const input = document.getElementById('valor');

input.addEventListener('input', () => {
    let valor = input.value.replace(/\D/g, '');
    valor = (parseInt(valor, 10) / 100).toFixed(2);

    input.value = valor
        .replace('.', ',')               // vírgula como separador decimal
        .replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // milhares com ponto
});
