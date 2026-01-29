(()=>{
  const root=document.documentElement;
  const themeBtn=document.getElementById('themeToggle');
  const sidebarBtn=document.getElementById('sidebarToggle');
  const overlay=document.getElementById('sidebarOverlay');

  const setTheme=(m)=>{
    root.setAttribute('data-theme', m);
    try{localStorage.setItem('ck_admin_theme', m);}catch(e){}
    if(themeBtn){
      const icon=themeBtn.querySelector('[data-icon]');
      const text=themeBtn.querySelector('[data-text]');
      if(m==='dark'){ if(icon) icon.textContent='☀️'; if(text) text.textContent='Light'; }
      else { if(icon) icon.textContent='🌙'; if(text) text.textContent='Dark'; }
    }
  };

  const saved=(()=>{try{return localStorage.getItem('ck_admin_theme');}catch(e){return null;}})();
  setTheme(saved || 'light');

  if(themeBtn) themeBtn.addEventListener('click', ()=>{
    const cur=root.getAttribute('data-theme')||'light';
    setTheme(cur==='dark'?'light':'dark');
  });

  const open=()=>document.body.classList.add('sidebar-open');
  const close=()=>document.body.classList.remove('sidebar-open');
  if(sidebarBtn) sidebarBtn.addEventListener('click', open);
  if(overlay) overlay.addEventListener('click', close);
  document.addEventListener('keydown', (e)=>{ if(e.key==='Escape') close(); });
  document.querySelectorAll('.sidebar a').forEach(a=>a.addEventListener('click', ()=>{ if(window.matchMedia('(max-width: 980px)').matches) close(); }));

  // Row entry animation
  document.querySelectorAll('table tbody tr').forEach((tr,i)=>{
    tr.style.opacity='0'; tr.style.transform='translateY(8px)';
    tr.style.transition='opacity .35s ease, transform .35s ease';
    setTimeout(()=>{ tr.style.opacity='1'; tr.style.transform='translateY(0)'; }, 40 + i*25);
  });
})();
