<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Choose Mode — Page 1</title>
  <style>
    :root{
      --bg-1:#1F8FB2; 
      --bg-2:#3CC0E9; 
      --card:#ffffff; 
      --accent:#1F8FB2; 
      --accent-2:#3CC0E9; 
      --muted:#6b7280;
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0; 
      font-family:Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      background:linear-gradient(135deg, var(--bg-1) 0%, var(--bg-2) 100%);
      color:#0f172a; 
      display:flex; 
      align-items:center; 
      justify-content:center; 
      padding:24px;
    }

    .card{
      width:100%; 
      max-width:1100px; /* bigger card */
      background:rgba(255,255,255,0.95); 
      border-radius:24px; 
      box-shadow:0 16px 50px rgba(0,0,0,0.25);
      padding:48px; /* more padding */
      display:flex; 
      flex-direction:column; 
      gap:32px; 
      align-items:center;
      backdrop-filter: blur(10px);
      animation:fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
      from {opacity:0; transform:translateY(20px);}
      to {opacity:1; transform:translateY(0);}
    }

    h1{margin:0; font-size:2rem; color:#0f172a;}
    p.lead{margin:0; color:var(--muted); font-size:1.2rem}

    .buttons{
      width:100%; display:flex; gap:24px; margin-top:20px; 
      align-items:center; justify-content:center;
      flex-direction:column;
    }

    .btn{
      border:0; 
      cursor:pointer; 
      border-radius:18px; 
      padding:22px 28px; /* bigger padding */
      font-size:1.3rem; /* bigger text */
      font-weight:600;
      display:inline-flex; 
      gap:14px; 
      align-items:center; 
      justify-content:center; 
      min-width:260px; /* bigger button width */
      transition:all .2s ease;
      box-shadow:0 8px 24px rgba(15,23,42,0.1);
      background:rgba(31,143,178,0.08);
      color:var(--accent);
    }

    .btn:hover{
      background:rgba(60,192,233,0.18);
      transform:translateY(-3px);
      box-shadow:0 10px 28px rgba(0,0,0,0.18);
    }

    .btn:active{transform:translateY(0)}

    .btn[aria-pressed="true"] {
      background:linear-gradient(90deg,var(--accent),var(--accent-2));
      color:white;
      box-shadow:0 10px 28px rgba(31,143,178,0.45);
    }

    .btn svg{width:28px;height:28px;flex:0 0 28px}

    @media (min-width:640px){
      .buttons{flex-direction:row}
      .btn{min-width:220px}
    }

    @media (max-width:420px){
      .btn{padding:20px; font-size:1.2rem; border-radius:20px}
    }

    .meta{
      display:flex; gap:12px; align-items:center; 
      color:#64748b; font-size:1.05rem;
    }
  </style>
</head>
<body>
  <main class="card" role="main">
    <header style="text-align:center">
      <h1>How would you like to continue? (Sign in)</h1>
    </header>

    <nav class="buttons" aria-label="Primary actions">
      <button class="btn btn--guest" id="btnGuest" aria-pressed="false">
        <svg viewBox="0 0 24 24" fill="none"><path d="M12 12a4 4 0 100-8 4 4 0 000 8zM3 20a9 9 0 0118 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Guest
      </button>

      <button class="btn btn--partner" id="btnPartner" aria-pressed="false">
        <svg viewBox="0 0 24 24" fill="none"><path d="M3 12l6 6 12-12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Partner
      </button>

      <button class="btn btn--rental" id="btnRental" aria-pressed="false">
        <svg viewBox="0 0 24 24" fill="none"><path d="M3 13l1-4h16l1 4v4a1 1 0 01-1 1h-1a1 1 0 01-1-1v-1H6v1a1 1 0 01-1 1H4a1 1 0 01-1-1v-4z" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path><circle cx="7.5" cy="16.5" r="1.5"/><circle cx="17.5" cy="16.5" r="1.5"/></svg>
        Car & Taxi Rental
      </button>
    </nav>

    <div class="meta" id="status" aria-live="polite">No selection yet.</div>
  </main>

  <script>
    const status = document.getElementById('status');
    const actions = {
      btnGuest: ()=>{ status.textContent = 'Continuing as guest...'; location.href = '/customer/login'; },
      btnPartner: ()=>{ status.textContent = 'Partner portal — redirecting...'; location.href = '/partner/login'; },
      btnRental: ()=>{ status.textContent = 'Showing car & taxi rental options...'; location.href = '/car-renter/login/email';  }
    };

    Object.keys(actions).forEach(id=>{
      const el = document.getElementById(id);
      el.addEventListener('click', ()=>{
        document.querySelectorAll('.btn').forEach(b=>b.setAttribute('aria-pressed','false'));
        el.setAttribute('aria-pressed','true');
        actions[id]();
      });
    });
  </script>
</body>
</html>
