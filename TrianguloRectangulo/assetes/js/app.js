function calcularTriangulo() {
    // 1. Obtenemos los valores de los inputs de la vista
    const baseInput = document.getElementById('txtBase');
    const alturaInput = document.getElementById('txtAltura');
    const areaInput = document.getElementById('txtA');
    const perimetroInput = document.getElementById('txtP');

    // 2. Convertimos a números decimales
    const base = parseFloat(baseInput.value);
    const altura = parseFloat(alturaInput.value);

    // 3. Validamos que sean números válidos y mayores a cero
    if (isNaN(base) || base <= 0 || isNaN(altura) || altura <= 0) {
        alert("Por favor, ingrese una base y altura válidas mayores a cero.");
        return;
    }

    // 4. Aplicamos las fórmulas geométricas del triángulo rectángulo
    const area = (base * altura) / 2;
    const hipotenusa = Math.sqrt(Math.pow(base, 2) + Math.pow(altura, 2));
    const perimetro = base + altura + hipotenusa;

    // 5. Mostramos los resultados en la vista limitando a 2 decimales
    areaInput.value = area.toFixed(2);
    perimetroInput.value = perimetro.toFixed(2);
}
