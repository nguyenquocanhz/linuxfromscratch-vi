(() => {
  const root = document.documentElement;
  const store = (k, v) => { try { v === undefined ? 0 : localStorage.setItem(k, v); return localStorage.getItem(k); } catch (e) { return null; } };

  document.getElementById('theme-btn')?.addEventListener('click', () => {
    const dark = root.dataset.theme ? root.dataset.theme === 'dark' : matchMedia('(prefers-color-scheme: dark)').matches;
    root.dataset.theme = dark ? 'light' : 'dark';
    store('theme', root.dataset.theme);
  });
  document.getElementById('menu-btn')?.addEventListener('click', () => document.body.classList.toggle('nav-open'));

  // Highlight the current page in the sidebar and open its chapter.
  const here = location.pathname.replace(/\/$/, '/index.html');
  document.querySelectorAll('.toc a').forEach(a => {
    if (a.pathname === here) {
      a.classList.add('current');
      let d = a.closest('details');
      while (d) { d.open = true; d = d.parentElement.closest('details'); }
      setTimeout(() => a.scrollIntoView({ block: 'center' }), 0);
    }
  });

  // Filter the table of contents.
  const filter = document.getElementById('toc-filter');
  filter?.addEventListener('input', () => {
    const q = filter.value.trim().toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/đ/g, 'd');
    document.querySelectorAll('.toc details').forEach(d => {
      let any = false;
      d.querySelectorAll('li').forEach(li => {
        const t = li.textContent.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, '').replace(/đ/g, 'd');
        const hit = !q || t.includes(q);
        li.style.display = hit ? '' : 'none';
        any ||= hit;
      });
      d.style.display = any || d.querySelector('summary').textContent.toLowerCase().includes(q) ? '' : 'none';
      if (q) d.open = any;
    });
  });

  // Copy buttons on command blocks.
  document.querySelectorAll('.book pre.userinput, .trick pre, .trick-card pre').forEach(pre => {
    const b = document.createElement('button');
    b.className = 'copy-btn';
    b.type = 'button';
    b.textContent = 'Sao chép';
    b.addEventListener('click', async () => {
      const text = (pre.querySelector('kbd, code') || pre).innerText;
      try { await navigator.clipboard.writeText(text); b.textContent = 'Đã chép ✓'; }
      catch (e) { b.textContent = 'Không chép được'; }
      setTimeout(() => (b.textContent = 'Sao chép'), 1600);
    });
    pre.appendChild(b);
  });

  // Tag filter on the tricks page.
  const tags = document.getElementById('tag-filter');
  tags?.addEventListener('click', e => {
    const btn = e.target.closest('button[data-tag]');
    if (!btn) return;
    tags.querySelectorAll('button').forEach(x => x.classList.toggle('active', x === btn));
    document.querySelectorAll('.trick-card').forEach(c => {
      c.style.display = !btn.dataset.tag || c.dataset.tags.split('|').includes(btn.dataset.tag) ? '' : 'none';
    });
  });
})();
