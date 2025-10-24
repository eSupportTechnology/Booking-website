@props(['amount', 'currency' => null])

@php
    $currencyService = app(\App\Services\CurrencyService::class);
    $currentCurrency = $currency ?? Session::get('currency', config('app.default_currency'));
    $convertedAmount = $currencyService->convert($amount, $currency ?? config('app.default_currency'), $currentCurrency);
    $formattedPrice = $currencyService->formatPriceWithSymbol($convertedAmount, $currentCurrency);
@endphp

<span {{ $attributes->merge(['class' => 'price']) }}
      data-original-amount="{{ $amount }}"
      data-original-currency="{{ $currency ?? config('app.default_currency') }}">
    {{ $formattedPrice }}
</span>
