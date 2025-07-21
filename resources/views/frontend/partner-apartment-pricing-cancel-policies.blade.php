<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Step 1</title>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs" defer></script>
</head>
<body class="p-6">

  <h2 class="text-xl font-bold mb-4">Step 1: Property Details</h2>
  
  <!-- Your form or content here -->

  <button 
    class="mt-4 px-4 py-2 bg-blue-600 text-white rounded"
    onclick="goToStep2()"
  >
    Next
  </button>

  <script>
    function goToStep2() {
      localStorage.setItem('pricingWizardStep', '2');
      window.location.href = '{{ route("wizard.step2") }}'; // Route to Step 2
    }
  </script>

</body>
</html>
