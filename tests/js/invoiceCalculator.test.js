
import { describe, it, expect } from 'vitest';
import { calculateInvoice } from '../../resources/js/utils/invoiceCalculator.js';

describe('Invoice Calculator', () => {

    it('calculates HT, VAT and TTC correctly', () => {
        const result = calculateInvoice(1000, 20);

        expect(result).toEqual({
            amountHT: 1000,
            taxRate: 20,
            amountTVA: 200,
            amountTTC: 1200,
        });
    });

    it('handles zero VAT correctly', () => {
        const result = calculateInvoice(1000, 0);

        expect(result.amountTVA).toBe(0);
        expect(result.amountTTC).toBe(1000);
    });

    it('handles zero invoice amount', () => {
        const result = calculateInvoice(0, 20);

        expect(result.amountHT).toBe(0);
        expect(result.amountTVA).toBe(0);
        expect(result.amountTTC).toBe(0);
    });

    it('rounds monetary amounts to two decimals', () => {
        const result = calculateInvoice(19.99, 20);

        expect(result.amountTVA).toBe(4);
        expect(result.amountTTC).toBe(23.99);
    });

    it('rejects negative invoice amounts', () => {
        expect(() => calculateInvoice(-100, 20))
            .toThrow('Amount and tax rate must be non-negative');
    });

    it('rejects negative tax rates', () => {
        expect(() => calculateInvoice(100, -20))
            .toThrow('Amount and tax rate must be non-negative');
    });

});
