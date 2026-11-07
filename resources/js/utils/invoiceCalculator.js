export function calculateInvoice(amountHT, taxRate){

    if (amountHT < 0 || taxRate < 0) {
        throw new Error("Amount and tax rate must be non-negative");
    }

    const amountTVA = amountHT * ( taxRate / 100 );
    const amountTTC = amountHT + amountTVA;

    return { 
        amountHT: Number(amountHT.toFixed(2)), 
        taxRate: taxRate, 
        amountTVA: Number(amountTVA.toFixed(2)), 
        amountTTC: Number(amountTTC.toFixed(2))
    };
}