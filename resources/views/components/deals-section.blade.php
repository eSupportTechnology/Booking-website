@props(['title' => 'Special Deals', 'limit' => 6])

<section class="py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $title }}</h2>
                <p class="text-gray-600 mt-1">Limited time offers you don't want to miss</p>
            </div>
            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                View All Deals →
            </a>
        </div>

        <div id="deals-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Deals will be loaded here via JavaScript -->
        </div>

        <div id="deals-loading" class="text-center py-8">
            <div class="inline-flex items-center px-4 py-2 font-semibold leading-6 text-sm shadow rounded-md text-gray-500 bg-white">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading deals...
            </div>
        </div>

        <div id="deals-error" class="text-center py-8 hidden">
            <p class="text-gray-500">No deals at the moment.</p>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadDeals();
});

function loadDeals() {
    const container = document.getElementById('deals-container');
    const loading = document.getElementById('deals-loading');
    const error = document.getElementById('deals-error');

    fetch('/api/deals/active?limit={{ $limit }}')
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(deals => {
            loading.classList.add('hidden');
            console.log('Deals loaded:', deals); // Debug log

            if (deals && Array.isArray(deals) && deals.length > 0) {
                container.innerHTML = deals.map(deal => createDealCard(deal)).join('');
            } else {
                container.innerHTML = '<div class="col-span-full text-center py-8"><p class="text-gray-500">No active deals available at the moment.</p></div>';
            }
        })
        .catch(err => {
            console.error('Error loading deals:', err);
            loading.classList.add('hidden');
            container.innerHTML = '<div class="col-span-full text-center py-8"><p class="text-red-500">Error loading deals. Please try again later.</p></div>';
        });
}

function createDealCard(deal) {
    const propertyRating = deal.property && deal.property.rating ?
        parseFloat(deal.property.rating).toFixed(1) : '4.5';

    const propertyCity = deal.property ? deal.property.city : 'Location';
    const propertyUrl = deal.property ? `/customer/properties/${deal.property.id}/book?deal_id=${deal.id}` : '#';
    
    let discountBadge = '';
    let priceDisplay = '';
    
    // Handle different deal types
    switch(deal.deal_type) {
        case 'percentage':
            discountBadge = `${deal.discount_percentage}% OFF`;
            break;
        case 'fixed':
            discountBadge = `$${deal.fixed_discount_amount} OFF`;
            break;
        case 'special':
            discountBadge = 'Special Offer';
            break;
        default:
            discountBadge = `${deal.discount_percentage}% OFF`;
    }
    
    if (deal.deal_type === 'special') {
        priceDisplay = `<span class="font-bold text-lg">${deal.special_offer_text}</span>`;
    } else {
        priceDisplay = `
            <span class="line-through opacity-75">$${deal.original_price}</span>
            <span class="font-bold text-lg ml-2">$${deal.discounted_price}</span>
        `;
    }

    return `
        <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
            <img src="${deal.property ? deal.property.image : '/images/property.png'}" alt="${deal.property ? deal.property.title : 'Property'}" class="w-full h-48 object-cover" onerror="this.src='/images/property.png'">
            <div class="p-4 text-white">
                <div class="flex items-center justify-between mb-2">
                    <span class="bg-white bg-opacity-20 text-xs font-semibold px-2 py-1 rounded-full">
                        🔥 HOT DEAL
                    </span>
                    <span class="text-xs font-medium">
                        ${discountBadge}
                    </span>
                </div>

                <h3 class="font-bold text-lg mb-2 line-clamp-2">${deal.title || 'Special Deal'}</h3>

                <p class="text-sm opacity-90 mb-3 line-clamp-2">${deal.description || 'Limited time offer'}</p>

                <div class="flex items-center justify-between mb-3">
                    <div class="text-sm">
                        ${priceDisplay}
                    </div>
                    <span class="text-xs bg-white bg-opacity-20 px-2 py-1 rounded">
                        ${propertyCity || 'Location'}
                    </span>
                </div>

                <div class="flex items-center justify-between text-xs mb-3">
                    <span>Valid until: ${formatDate(deal.end_date)}</span>
                    <span>⭐ ${propertyRating}</span>
                </div>

                <a href="${propertyUrl}"
                   class="block w-full bg-white text-orange-600 font-semibold py-2 px-4 rounded text-center hover:bg-gray-100 transition-colors duration-200">
                    Book This Deal
                </a>
            </div>
        </div>
    `;
}

function formatCurrency(amount, currency) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: currency || 'USD'
    }).format(amount);
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric'
    });
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
