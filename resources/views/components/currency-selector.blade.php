<div class="currency-selector">
    <select id="currency-select" class="form-select" onchange="changeCurrency(this.value)">
        @foreach(app(\App\Services\CurrencyService::class)->getSupportedCurrencies() as $currency)
            <option value="{{ $currency }}" {{ app(\App\Services\CurrencyManager::class)->getUserCurrency() === $currency ? 'selected' : '' }}>
                {{ $currency }}
            </option>
        @endforeach
    </select>
</div>

<script>
function changeCurrency(currency) {
    fetch('/set-currency', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({currency: currency})
    }).then(() => location.reload());
}
</script>