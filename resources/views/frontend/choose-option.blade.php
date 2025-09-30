<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Choose Mode — Guest / Partner / Car & Taxi Rental</title>
  <style>
    :root{
      --bg:#f6f7fb; --card:#ffffff; --accent:#2563eb; --accent-2:#06b6d4; --muted:#6b7280;
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0; font-family:Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background:linear-gradient(180deg,var(--bg),#eef2ff 60%); color:#0f172a; -webkit-font-smoothing:antialiased;
      display:flex; align-items:center; justify-content:center; padding:24px;
    }

    .card{
      width:100%; max-width:940px; background:var(--card); border-radius:16px; box-shadow:0 10px 30px rgba(16,24,40,0.08);
      padding:28px; display:flex; flex-direction:column; gap:18px; align-items:center;
    }

    h1{margin:0; font-size:1.375rem}
    p.lead{margin:0; color:var(--muted); font-size:0.95rem}

    .buttons{
      width:100%; display:flex; gap:14px; margin-top:6px; align-items:center; justify-content:center;
      flex-direction:column;
    }

    .btn{
      -webkit-tap-highlight-color:transparent;
      border:0; cursor:pointer; border-radius:12px; padding:14px 20px; font-size:1rem; font-weight:600;
      display:inline-flex; gap:10px; align-items:center; justify-content:center; min-width:220px; transition:transform .12s ease, box-shadow .12s ease;
      box-shadow:0 6px 18px rgba(15,23,42,0.06);
    }

    .btn:active{transform:translateY(1px)}

    .btn--guest{background:transparent; color:var(--accent); border:2px solid rgba(37,99,235,0.12)}
    .btn--partner{background:linear-gradient(90deg,var(--accent),var(--accent-2)); color:white}
    .btn--rental{background:white; color:#0f172a; border:2px solid rgba(15,23,42,0.06)}

    .btn svg{width:18px;height:18px;flex:0 0 18px}

    /* responsive layout: horizontal row on wider screens */
    @media (min-width:640px){
      .buttons{flex-direction:row}
      .btn{min-width:160px}
    }

    /* make touch targets larger on small screens */
    @media (max-width:420px){
      .btn{padding:16px 18px; font-size:1.05rem; border-radius:14px}
    }

    /* helper for subtle description row */
    .meta{display:flex; gap:12px; align-items:center; color:var(--muted); font-size:0.9rem}

  </style>
</head>
<body>
  <main class="card" role="main">
    <header style="text-align:center">
      <h1>How would you like to continue?</h1>
      <p class="lead">Choose an option below — the page is responsive and keyboard-accessible.</p>
    </header>

    <nav class="buttons" aria-label="Primary actions">
      <button class="btn btn--guest" id="btnGuest" aria-pressed="false" aria-label="Continue as guest">
        <!-- user icon -->
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zM3 20a9 9 0 0118 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Guest
      </button>

      <button class="btn btn--partner" id="btnPartner" aria-pressed="false" aria-label="Partner sign up or login">
        <!-- handshake icon -->
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3 12l6 6 12-12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Partner
      </button>

      <button class="btn btn--rental" id="btnRental" aria-pressed="false" aria-label="Car and taxi rental options">
        <!-- car icon -->
        <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M3 13l1-4h16l1 4v4a1 1 0 01-1 1h-1a1 1 0 01-1-1v-1H6v1a1 1 0 01-1 1H4a1 1 0 01-1-1v-4z" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path><circle cx="7.5" cy="16.5" r="1.5"/><circle cx="17.5" cy="16.5" r="1.5"/></svg>
        Car & Taxi Rental
      </button>
    </nav>

    <div class="meta" id="status" aria-live="polite">No selection yet.</div>
  </main>

  <script>
    // Simple JS to make buttons "work" — replace with navigation or API calls as needed.
    const status = document.getElementById('status');
    const actions = {
      btnGuest: ()=>{
        status.textContent = 'Continuing as guest...';
        // Example: navigate to guest landing page
        // location.href = '/guest';
      },
      btnPartner: ()=>{
        status.textContent = 'Partner portal — redirecting...';
         location.href = '/partner/login';
      },
      btnRental: ()=>{
        status.textContent = 'Showing car & taxi rental options...';
        // location.href = '/rentals';
      }
    };

    Object.keys(actions).forEach(id=>{
      const el = document.getElementById(id);
      el.addEventListener('click', ()=>{
        // toggle aria-pressed for a11y feedback
        document.querySelectorAll('.btn').forEach(b=>b.setAttribute('aria-pressed','false'));
        el.setAttribute('aria-pressed','true');
        actions[id]();
      });

      // keyboard: Enter/Space already trigger click on <button>
    });

    // Allow activation by swipe-like keyboard shortcuts (optional)
    window.addEventListener('keydown', e=>{
      if(e.altKey && e.key === '1') document.getElementById('btnGuest').click();
      if(e.altKey && e.key === '2') document.getElementById('btnPartner').click();
      if(e.altKey && e.key === '3') document.getElementById('btnRental').click();
    });
  </script>
</body>
</html>
