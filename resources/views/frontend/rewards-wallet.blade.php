<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Rewards & Wallet</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
    rel="stylesheet"
  />
</head>
<body class="bg-gray-50" style="font-family: 'Poppins', sans-serif;">

  <!-- Header -->
  <header class="text-white py-4" style="background-color:#1F8FB2;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
      <div
        class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0"
      >
        <!-- Logo -->
        <div class="w-full md:w-auto">
          <div class="flex flex-col items-start space-y-1">
            <h1 class="text-2xl font-bold">Bookintour.com</h1>
            <p
              class="text-white opacity-90 tracking-tight text-xs sm:text-sm"
              style="font-size: 12px;"
            >
              <span class="underline cursor-pointer">My Account</span> &gt;
              Rewards &amp; Wallet
            </p>
          </div>
        </div>

        <!-- Controls -->
        <div
          class="flex items-center gap-4 sm:gap-5 flex-wrap justify-center md:justify-end"
        >
          <span class="text-base sm:text-lg text-white whitespace-nowrap">LKR</span>
          <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full overflow-hidden">
            <img
              src="https://flagcdn.com/gb.svg"
              alt="UK Flag"
              class="w-full h-full object-cover"
            />
          </div>
          <a
            href="#"
            class="flex items-center justify-center w-7 h-7 bg-[#1F8FB2] rounded-full hover:bg-[#29ACD5] text-white border border-white text-sm font-semibold"
            title="Help"
            >?</a
          >
          <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
            <div
              class="bg-yellow-400 text-black rounded-full w-7 h-7 sm:w-9 sm:h-9 flex items-center justify-center text-sm sm:text-base font-semibold"
            >
              D
            </div>
            <div>
              <p class="font-semibold leading-none text-sm sm:text-base whitespace-nowrap">
                Dinidu Dananjaya
              </p>
              <p class="text-xs sm:text-sm text-yellow-300">Genius Level 1</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Language Modal Script -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const languageButton = document.getElementById("language-button");
      const languageModal = document.getElementById("language-modal");
      const closeLanguageModal = document.getElementById("close-language-modal");

      if (languageButton && languageModal && closeLanguageModal) {
        languageButton.addEventListener("click", () =>
          languageModal.classList.remove("hidden")
        );
        closeLanguageModal.addEventListener("click", () =>
          languageModal.classList.add("hidden")
        );
      }
    });
  </script>

  <!-- Main Content -->
  <main class="bg-[#1F8FB2] text-white py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20 text-center space-y-4">
      <h1 class="text-2xl font-semibold">Rewards & Wallet</h1>
      <p class="text-lg">
        Save money on your next adventure with
        <span class="font-bold">eSupport.com</span>
      </p>
    </div>
  </main>

  <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20 mt-[-40px] relative z-10">
    <div
      class="bg-white rounded-lg shadow-md p-9 flex flex-wrap sm:flex-nowrap items-center justify-between gap-6"
    >
      <div class="flex items-center gap-6 flex-1 min-w-[240px]">
        <img
          src="https://img.icons8.com/external-flat-juicy-fish/60/external-wallet-cyber-monday-flat-flat-juicy-fish.png"
          alt="Wallet Icon"
          class="w-16 h-16 flex-shrink-0"
        />
        <div class="space-y-3 text-gray-800">
          <h2 class="text-xl font-bold">Wallet Balance</h2>
          <p class="text-sm text-gray-500">Includes all spendable rewards</p>
          <h2 class="text-xl font-bold">LKR 0</h2>
        </div>
      </div>
      <div class="text-right min-w-[200px]">
        <div class="text-sm text-gray-700 mb-4">
          Credits: <span class="font-medium">LKR 0</span>
        </div>
        <div class="text-sm text-gray-700 mb-4">
          Vouchers (0): <span class="font-medium">LKR 0</span>
        </div>
        <a href="#" class="text-blue-600 text-sm hover:underline"
          >Browse Rewards and Wallet activity</a
        >
      </div>
    </div>

    <div class="text-sm text-gray-700 mt-4">
      Got a coupon code?
      <a href="#" class="text-blue-600 hover:underline">Add coupon into wallet</a>
    </div>

    <div class="mt-10 border-t pt-6 space-y-6">
      <h2 class="text-lg font-semibold text-gray-800">What’s Rewards & Wallet?</h2>

      <div class="grid md:grid-cols-3 gap-6 text-sm text-gray-700">
        <div class="flex items-start gap-2">
          <span class="text-2xl">🎁</span>
          <div>
            <p class="font-medium">Book and earn travel rewards</p>
            <p>
              Credits, vouchers, you name it! These are all spendable on your next
              eSupport.com trip.
            </p>
          </div>
        </div>
        <div class="flex items-start gap-2">
          <span class="text-2xl">📊</span>
          <div>
            <p class="font-medium">Track everything at a glance</p>
            <p>
              Your Wallet keeps all rewards safe, while updating you about your
              earnings and spendings.
            </p>
          </div>
        </div>
        <div class="flex items-start gap-2">
          <span class="text-2xl">💳</span>
          <div>
            <p class="font-medium">Pay with Wallet to save money</p>
            <p>
              If a booking accepts any rewards in your Wallet, it’ll appear during
              payment for spending.
            </p>
          </div>
        </div>
      </div>

      <div class="text-right">
        <a href="#" class="text-blue-600 text-sm hover:underline">Need Help? Visit FAQs</a>
      </div>
    </div>

    <div
      class="text-xs text-gray-600 mt-10 border-t pt-4"
    >
      Countries . Regions . Cities . Districts . Airports . Hotels . Places of interest .
      Holiday Homes . Apartments . Resorts . Villas . Hostels . B&amp;Bs . Guest Houses .
      Unique places to stay . All destinations. All flight destinations. All car hire
      locations. All holiday destinations. Guides . Discover . Reviews . Discover
      monthly stays
    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-gray-100 pt-8 pb-4 text-sm text-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-20">
      <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
        <!-- Footer Columns -->
        <div>
          <p class="font-semibold mb-2">Support</p>
          <ul class="space-y-1">
            <li>Coronavirus (COVID-19) FAQs</li>
            <li>Manage your trips</li>
            <li>Contact Customer Service</li>
            <li>Safety resource centre</li>
          </ul>
        </div>
        <div>
          <p class="font-semibold mb-2">Discover</p>
          <ul class="space-y-1">
            <li>Genius loyalty programme</li>
            <li>Seasonal and holiday deals</li>
            <li>Travel articles</li>
            <li>eSupport.com for Business</li>
            <li>Traveller Review Awards</li>
            <li>Car hire</li>
            <li>Flight finder</li>
            <li>Restaurant reservations</li>
            <li>eSupport.com for Travel Agents</li>
          </ul>
        </div>
        <div>
          <p class="font-semibold mb-2">Terms and settings</p>
          <ul class="space-y-1">
            <li>Privacy & cookies</li>
            <li>Terms and conditions</li>
            <li>Partner dispute</li>
            <li>Modern Slavery Statement</li>
            <li>Human Rights Statement</li>
          </ul>
        </div>
        <div>
          <p class="font-semibold mb-2">Partners</p>
          <ul class="space-y-1">
            <li>Extranet login</li>
            <li>Partner help</li>
            <li>List your property</li>
            <li>Become an affiliate</li>
          </ul>
        </div>
        <div>
          <p class="font-semibold mb-2">About</p>
          <ul class="space-y-1">
            <li>About eSupport.com</li>
            <li>How we work</li>
            <li>Sustainability</li>
            <li>Press centre</li>
            <li>Careers</li>
            <li>Investor relations</li>
            <li>Corporate contact</li>
          </ul>
        </div>
      </div>

      <div class="mt-20">
        <div class="flex items-center space-x-4 mb-2">
          <div class="w-4 h-4 rounded-full overflow-hidden -ml-0">
            <img src="https://flagcdn.com/gb.svg" alt="Flag" class="w-full h-full object-cover" />
          </div>
          <span class="font-black text-sm text-gray-800">LKR</span>
        </div>

        <hr class="border-t border-gray-300 my-3 w-full mx-auto" />

        <div class="text-center text-xs text-gray-500">
          <p class="leading-snug">
            All Rights Reserved. © 2025 eSupport.com &nbsp;&nbsp; Powered by eSupport ©
          </p>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
