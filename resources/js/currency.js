// Currency utilities
const formatPrice = async (amount, fromCurrency, toCurrency = null) => {
    try {
        const response = await fetch('/api/convert-price', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                amount: amount,
                from: fromCurrency,
                to: toCurrency || document.getElementById('current-currency')?.textContent || 'USD'
            })
        });
        const data = await response.json();
        return data.formattedPrice;
    } catch (error) {
        console.error('Price conversion failed:', error);
        const symbols = { USD: '$', EUR: '€', GBP: '£', LKR: 'Rs' };
        const symbol = symbols[fromCurrency] || fromCurrency;
        return symbol + amount.toLocaleString();
    }
};

// Auto-update prices when currency changes
document.addEventListener('DOMContentLoaded', () => {
    const currencySelector = document.getElementById('current-currency');
    if (!currencySelector) return;

    const updatePrices = async () => {
        const prices = document.querySelectorAll('[data-original-amount]');
        for (const priceElement of prices) {
            const amount = priceElement.dataset.originalAmount;
            const currency = priceElement.dataset.originalCurrency;
            const formattedPrice = await formatPrice(amount, currency);
            priceElement.textContent = formattedPrice;
        }
    };

    // Update prices when currency changes
    currencySelector.addEventListener('currency-changed', updatePrices);
});

export { formatPrice };