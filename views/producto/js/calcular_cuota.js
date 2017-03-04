function computeForm(F, cu_prod) {
    cuo = F.cu_num.value;
    pre = F.pre_cu.value;
    cuotas = F.cuotas.value;
    cantidad = F.cantidad.value;
    monto = F.principal.value * F.cantidad.value;
    tasa = 42;
    //gasto_interes = 5;
    gasto_interes = F.gasto_interes.value;
    gasto_monto = (monto * gasto_interes) / 100;
    monto_total_prestamo = parseInt(monto) + parseInt(gasto_monto);
    anual = tasa / 100;

    mes = parseFloat(anual) / 12;
    aux = (Math.pow((1 + mes), cuotas) - 1);
    aux2 = (mes * Math.pow((1 + mes), cuotas));
    aux3 = aux / aux2;
    monto_cuota = monto_total_prestamo / aux3;
    monto_cuota = monto_cuota.toFixed(0);
    var num = monto_cuota.replace(/\./g, "");
    //console.log(Math.round10(num,-1));
    //console.log(Math.ceil10(num,-1));
    num = num.toString().split("").reverse().join("").replace(/(?=\d*\.?)(\d{3})/g, '$1.');
    num = num.split("").reverse().join("").replace(/^[\.]/, "");

    if (cuo === cuotas && cantidad === 1 && pre !== 0) {
        F.payment.value = "Gs." + pre;
    } else
    {
        F.payment.value = "Gs." + num;
    }
}