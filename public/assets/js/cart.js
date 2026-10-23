// assets/js/cart.js - GrowShop Ultra-Modern Cart & Dynamic Catalog Controller

const FREE_SHIPPING_THRESHOLD = 40000; // CLP $40.000 para Envío Gratis

const state = {
  products: [],
  filtered: [],
  cart: JSON.parse(localStorage.getItem('grow_cart') || '[]'),
  taxRate: 0.19,
  activeCategory: 'all'
};

const els = {};

document.addEventListener('DOMContentLoaded', () => {
  cacheEls();
  loadProducts();
  bindUI();
  renderCart();
});

function cacheEls(){
  els.grid = document.getElementById('productsGrid');
  els.search = document.getElementById('searchInput');
  els.category = document.getElementById('categoryFilter');
  els.sort = document.getElementById('sortSelect');
  els.categoryChips = document.getElementById('categoryChips');
  els.cartItems = document.getElementById('cartItems');
  els.subtotal = document.getElementById('cartSubtotal');
  els.tax = document.getElementById('cartTax');
  els.total = document.getElementById('cartTotal');
  els.cartCountBadge = document.getElementById('cartCountBadge');
  els.navCartCount = document.getElementById('navCartCount');
  els.cartHeaderCount = document.getElementById('cartHeaderCount');
  els.whatsappBtn = document.getElementById('whatsappBtn');
  els.checkoutBtn = document.getElementById('checkoutBtn');
  els.clearCartBtn = document.getElementById('clearCartBtn');
  els.shippingMeterBar = document.getElementById('shippingMeterBar');
  els.shippingMeterText = document.getElementById('shippingMeterText');
  els.cartShippingBadge = document.getElementById('cartShippingBadge');
}

async function loadProducts(){
  try {
    const res = await fetch('/api/products');
    const data = await res.json();
    state.products = data.map(p => ({
      id: String(p.id),
      nombre: p.name,
      desc: p.description || '',
      precio: parseFloat(p.price),
      categoria: p.category || 'Cultivo',
      img: p.image || 'assets/img/placeholder.webp'
    }));

    // Sincronizar items antiguos en el carrito para que tengan imagen y categoría
    let cartModified = false;
    state.cart.forEach(item => {
      if (!item.img || !item.categoria) {
        const prod = state.products.find(p => p.id === String(item.id));
        if (prod) {
          if (!item.img) item.img = prod.img;
          if (!item.categoria) item.categoria = prod.categoria;
          cartModified = true;
        }
      }
    });
    if (cartModified) {
      persistCart();
      renderCart();
    }

    state.filtered = [...state.products];
    renderProducts();
  } catch (e){
    if(els.grid) {
      els.grid.innerHTML = `
        <div class="col-12 text-center py-5">
          <i class="bi bi-exclamation-circle text-danger fs-1 mb-2"></i>
          <p class="text-danger small">No se pudo cargar el catálogo de productos.</p>
        </div>`;
    }
    console.error(e);
  }
}

function bindUI(){
  if(els.search) els.search.addEventListener('input', () => applyFilters());
  if(els.category) els.category.addEventListener('change', () => {
    state.activeCategory = els.category.value;
    syncChips();
    applyFilters();
  });
  if(els.sort) els.sort.addEventListener('change', () => {
    sortProducts();
    renderProducts();
  });
  if(els.whatsappBtn) els.whatsappBtn.addEventListener('click', sendWhatsApp);
  if(els.checkoutBtn) els.checkoutBtn.addEventListener('click', openPaymentModal);
  if(els.clearCartBtn) els.clearCartBtn.addEventListener('click', clearCart);

  // Enlazar chips de categorías
  if(els.categoryChips) {
    els.categoryChips.addEventListener('click', e => {
      const chip = e.target.closest('.category-chip');
      if (chip) {
        state.activeCategory = chip.dataset.category || 'all';
        syncChips();
        if(els.category) els.category.value = state.activeCategory;
        applyFilters();
      }
    });
  }
}

function syncChips(){
  if(!els.categoryChips) return;
  els.categoryChips.querySelectorAll('.category-chip').forEach(c => {
    if(c.dataset.category === state.activeCategory) {
      c.classList.add('active');
    } else {
      c.classList.remove('active');
    }
  });
}

function applyFilters(){
  const q = (els.search?.value || '').toLowerCase().trim();
  const cat = state.activeCategory;

  state.filtered = state.products.filter(p => {
    const matchQ = !q || p.nombre.toLowerCase().includes(q) || p.desc.toLowerCase().includes(q);
    const matchC = cat === 'all' || p.categoria.toLowerCase() === cat.toLowerCase();
    return matchQ && matchC;
  });

  sortProducts();
  renderProducts();
}

function sortProducts(){
  if(!els.sort) return;
  switch(els.sort.value){
    case 'priceAsc': state.filtered.sort((a,b)=>a.precio-b.precio); break;
    case 'priceDesc': state.filtered.sort((a,b)=>b.precio-a.precio); break;
    case 'nameAsc': state.filtered.sort((a,b)=>a.nombre.localeCompare(b.nombre)); break;
    default: break;
  }
}

function resolveImgSrc(raw) {
  if (!raw) return '/assets/img/placeholder.webp';
  if (raw.startsWith('http://') || raw.startsWith('https://')) return raw;
  return raw.startsWith('/') ? raw : '/' + raw;
}

function renderProducts(){
  if(!els.grid) return;
  if(state.filtered.length === 0){
    els.grid.innerHTML = `
      <div class="col-12 text-center py-5">
        <i class="bi bi-search fs-1 text-secondary d-block mb-3"></i>
        <h5 class="fw-bold">No encontramos productos coincidentes</h5>
        <p class="text-secondary small">Prueba cambiando tu búsqueda o seleccionando otra categoría.</p>
      </div>`;
    return;
  }

  els.grid.innerHTML = state.filtered.map(p => {
    const imgSrc = resolveImgSrc(p.img);
    return `
    <div class="col-12 col-sm-6 col-md-4 col-lg-3" id="product-${p.id}">
      <div class="feature-card h-100 d-flex flex-column">
        <div class="img-wrapper mb-3 position-relative">
          <img src="${imgSrc}" alt="${p.nombre}" class="img-zoom" loading="lazy" onerror="this.src='/assets/img/placeholder.webp'">
          <span class="badge bg-dark bg-opacity-75 text-white position-absolute bottom-0 start-0 m-2 px-2 py-1 rounded-pill small">
            ${p.categoria}
          </span>
        </div>
        <div class="d-flex flex-column flex-grow-1">
          <h6 class="mb-1 fw-bold text-truncate" title="${p.nombre}">${p.nombre}</h6>
          <p class="text-secondary small flex-grow-1 mb-3 text-truncate-2">${p.desc}</p>
          <div class="d-flex flex-column gap-2 mt-auto">
            <span class="fs-5 fw-bold text-gradient">$${p.precio.toLocaleString('es-CL')}</span>
            <button class="btn btn-gradient btn-sm w-100 fw-semibold" data-add="${p.id}">
              <i class="bi bi-cart-plus me-1"></i> Añadir
            </button>
          </div>
        </div>
      </div>
    </div>`;
  }).join('');

  els.grid.querySelectorAll('[data-add]').forEach(btn => {
    btn.addEventListener('click', () => addToCart(btn.dataset.add, btn));
  });
}

function addToCart(id, btn){
  const prod = state.products.find(p => p.id === String(id));
  if(!prod) return;

  const item = state.cart.find(i => String(i.id) === String(id));
  if(item){
    item.qty++;
  } else {
    state.cart.push({
      id: prod.id,
      nombre: prod.nombre,
      precio: prod.precio,
      categoria: prod.categoria,
      img: prod.img,
      qty: 1
    });
  }

  persistCart();
  renderCart();
  animateBadge();

  if(btn){
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-check-lg me-1"></i> ¡Añadido!';
    btn.classList.add('btn-added');
    btn.disabled = true;

    setTimeout(() => {
      btn.innerHTML = originalHtml;
      btn.classList.remove('btn-added');
      btn.disabled = false;
    }, 1100);
  }

  showToast(prod);
}

function renderCart(){
  if(!els.cartItems) return;

  const subtotal = state.cart.reduce((acc, i) => acc + (i.precio * i.qty), 0);
  updateShippingMeter(subtotal);

  if(state.cart.length === 0){
    els.cartItems.innerHTML = `
      <div class="cart-empty-box">
        <div class="cart-empty-circle">
          <i class="bi bi-bag-heart"></i>
        </div>
        <h6 class="fw-bold mb-1">Tu carrito está esperando</h6>
        <p class="text-secondary small mb-3">
          Explora nuestros fertilizantes, luces, sustratos y semillas seleccionadas.
        </p>
        <a href="/shop" data-bs-dismiss="offcanvas" class="btn btn-gradient btn-sm px-4">
          <i class="bi bi-shop me-1"></i> Explorar Tienda
        </a>
      </div>`;
  } else {
    els.cartItems.innerHTML = state.cart.map(i => {
      const imgSrc = resolveImgSrc(i.img);
      const lineTotal = i.precio * i.qty;
      return `
      <div class="cart-item-card" id="cart-item-${i.id}">
        <div class="cart-item-thumb-wrapper">
          <img src="${imgSrc}" alt="${i.nombre}" loading="lazy" onerror="this.src='/assets/img/placeholder.webp'">
        </div>
        <div class="cart-item-info">
          <span class="cart-item-cat">${i.categoria || 'Cultivo'}</span>
          <h6 class="cart-item-title" title="${i.nombre}">${i.nombre}</h6>
          <div class="cart-item-price-unit">$${i.precio.toLocaleString('es-CL')} c/u</div>
          <div class="cart-qty-stepper">
            <button class="cart-stepper-btn" data-dec="${i.id}" title="Disminuir unidad" aria-label="Disminuir una unidad">
              <i class="bi bi-dash"></i>
            </button>
            <span class="cart-stepper-val">${i.qty}</span>
            <button class="cart-stepper-btn" data-inc="${i.id}" title="Aumentar unidad" aria-label="Aumentar una unidad">
              <i class="bi bi-plus"></i>
            </button>
          </div>
        </div>
        <div class="cart-item-actions">
          <button class="cart-del-btn" data-del="${i.id}" title="Quitar del carrito" aria-label="Eliminar producto">
            <i class="bi bi-trash3"></i>
          </button>
          <span class="cart-item-total">$${lineTotal.toLocaleString('es-CL')}</span>
        </div>
      </div>`;
    }).join('');
  }

  els.cartItems.querySelectorAll('[data-inc]').forEach(b => b.addEventListener('click', () => changeQty(b.dataset.inc, 1)));
  els.cartItems.querySelectorAll('[data-dec]').forEach(b => b.addEventListener('click', () => changeQty(b.dataset.dec, -1)));
  els.cartItems.querySelectorAll('[data-del]').forEach(b => b.addEventListener('click', () => removeItem(b.dataset.del)));

  updateTotals();
  updateBadge();
}

function updateShippingMeter(subtotal){
  if(!els.shippingMeterBar || !els.shippingMeterText) return;

  if(subtotal <= 0){
    els.shippingMeterBar.style.width = '0%';
    els.shippingMeterBar.classList.remove('completed');
    els.shippingMeterText.innerHTML = `Envío gratis por compras sobre <strong>$${FREE_SHIPPING_THRESHOLD.toLocaleString('es-CL')}</strong> 🚚`;
    if(els.cartShippingBadge){
      els.cartShippingBadge.className = 'badge bg-secondary bg-opacity-25 text-secondary';
      els.cartShippingBadge.textContent = 'Calculado al checkout';
    }
  } else if(subtotal < FREE_SHIPPING_THRESHOLD){
    const remaining = FREE_SHIPPING_THRESHOLD - subtotal;
    const pct = Math.min(98, Math.max(10, Math.round((subtotal / FREE_SHIPPING_THRESHOLD) * 100)));
    els.shippingMeterBar.style.width = `${pct}%`;
    els.shippingMeterBar.classList.remove('completed');
    els.shippingMeterText.innerHTML = `¡Te faltan <strong>$${remaining.toLocaleString('es-CL')}</strong> para <strong>Envío Gratis</strong>! 🚚`;
    if(els.cartShippingBadge){
      els.cartShippingBadge.className = 'badge bg-secondary bg-opacity-25 text-secondary';
      els.cartShippingBadge.textContent = 'Calculado al checkout';
    }
  } else {
    els.shippingMeterBar.style.width = '100%';
    els.shippingMeterBar.classList.add('completed');
    els.shippingMeterText.innerHTML = `🎉 <strong>¡Felicidades! Calificas para Envío Gratis a todo Chile</strong>`;
    if(els.cartShippingBadge){
      els.cartShippingBadge.className = 'badge bg-success text-white';
      els.cartShippingBadge.textContent = '¡GRATIS!';
    }
  }
}

function changeQty(id, delta){
  const item = state.cart.find(i => String(i.id) === String(id));
  if(!item) return;
  item.qty += delta;
  if(item.qty <= 0){
    state.cart = state.cart.filter(i => String(i.id) !== String(id));
  }
  persistCart();
  renderCart();
}

function removeItem(id){
  const el = document.getElementById(`cart-item-${id}`);
  if(el){
    el.style.opacity = '0';
    el.style.transform = 'translateX(20px)';
    setTimeout(() => {
      state.cart = state.cart.filter(i => String(i.id) !== String(id));
      persistCart();
      renderCart();
    }, 200);
  } else {
    state.cart = state.cart.filter(i => String(i.id) !== String(id));
    persistCart();
    renderCart();
  }
}

function clearCart(){
  if(state.cart.length === 0) return;
  if(!confirm('¿Deseas vaciar todos los productos del carrito?')) return;
  state.cart = [];
  persistCart();
  renderCart();
}

function persistCart(){
  localStorage.setItem('grow_cart', JSON.stringify(state.cart));
}

function updateTotals(){
  const sub = state.cart.reduce((acc, i) => acc + (i.precio * i.qty), 0);
  const tax = Math.round(sub * state.taxRate);
  const tot = sub + tax;

  if(els.subtotal) els.subtotal.textContent = `$${Math.round(sub).toLocaleString('es-CL')}`;
  if(els.tax) els.tax.textContent = `$${tax.toLocaleString('es-CL')}`;
  if(els.total) els.total.textContent = `$${tot.toLocaleString('es-CL')}`;
}

function updateBadge(){
  const count = state.cart.reduce((a, b) => a + b.qty, 0);

  // Floating button badge
  if(els.cartCountBadge){
    if(count > 0){
      els.cartCountBadge.textContent = count;
      els.cartCountBadge.classList.remove('d-none');
    } else {
      els.cartCountBadge.classList.add('d-none');
    }
  }

  // Navbar badge
  if(els.navCartCount){
    if(count > 0){
      els.navCartCount.textContent = count;
      els.navCartCount.classList.remove('d-none');
    } else {
      els.navCartCount.classList.add('d-none');
    }
  }

  // Header pill count
  if(els.cartHeaderCount){
    els.cartHeaderCount.textContent = `${count} ${count === 1 ? 'ítem' : 'ítems'}`;
  }
}

function animateBadge(){
  if(els.cartCountBadge){
    els.cartCountBadge.classList.add('pulse-anim');
    setTimeout(() => els.cartCountBadge.classList.remove('pulse-anim'), 400);
  }
  if(els.navCartCount){
    els.navCartCount.classList.add('pulse-anim');
    setTimeout(() => els.navCartCount.classList.remove('pulse-anim'), 400);
  }
}

function showToast(prod){
  let toast = document.getElementById('gsToast');
  if(!toast){
    toast = document.createElement('div');
    toast.id = 'gsToast';
    toast.className = 'gs-toast';
    document.body.appendChild(toast);
  }

  const name = typeof prod === 'object' ? prod.nombre : prod;
  const rawImg = typeof prod === 'object' ? prod.img : 'assets/img/placeholder.webp';
  const imgSrc = resolveImgSrc(rawImg);

  toast.innerHTML = `
    <img src="${imgSrc}" class="gs-toast-thumb" alt="${name}" onerror="this.src='/assets/img/placeholder.webp'">
    <div class="flex-grow-1 overflow-hidden">
      <span class="d-block small text-success fw-bold"><i class="bi bi-check2-circle me-1"></i> Añadido al carrito</span>
      <span class="d-block small fw-semibold text-truncate">${name}</span>
    </div>
    <button class="btn btn-sm btn-gradient px-2.5 py-1 ms-1 text-nowrap" data-bs-toggle="offcanvas" data-bs-target="#cartCanvas" style="font-size: 0.75rem;">
      Ver
    </button>
  `;

  toast.classList.add('show');
  clearTimeout(toast._timeout);
  toast._timeout = setTimeout(() => toast.classList.remove('show'), 3200);
}

function sendWhatsApp(){
  if(state.cart.length === 0){
    alert('Tu carrito está vacío. Añade productos antes de cotizar.');
    return;
  }

  const sub = state.cart.reduce((a, b) => a + (b.precio * b.qty), 0);
  const tax = Math.round(sub * state.taxRate);
  const total = sub + tax;
  const isFree = sub >= FREE_SHIPPING_THRESHOLD;
  const shippingTxt = isFree ? '¡GRATIS a todo Chile! 🚚' : 'Por cotizar según tu comuna/región';

  const lines = state.cart.map(i => `🌱 *${i.nombre}*\n   ↳ Cantidad: *${i.qty}* | Valor: $${(i.precio * i.qty).toLocaleString('es-CL')}`);

  const msg = `🌿 *¡HOLA GROWSHOP! QUISIERA CONFIRMAR EL SIGUIENTE PEDIDO:*\n\n` +
    `${lines.join('\n\n')}\n\n` +
    `──────────────────────────\n` +
    `📦 *Subtotal:* $${sub.toLocaleString('es-CL')}\n` +
    `🧾 *IVA (19%):* $${tax.toLocaleString('es-CL')}\n` +
    `🚚 *Despacho:* ${shippingTxt}\n` +
    `✨ *TOTAL ESTIMADO: $${total.toLocaleString('es-CL')}*\n` +
    `──────────────────────────\n\n` +
    `¿Tienen disponibilidad para coordinar despacho o retiro?`;

  const phone = '56912345678';
  window.open(`https://wa.me/${phone}?text=${encodeURIComponent(msg)}`, '_blank');
}

function openPaymentModal(){
  if(state.cart.length === 0){
    alert('Tu carrito está vacío. Agrega productos para iniciar el pago.');
    return;
  }
  const modalEl = document.getElementById('paymentModal');
  if(!modalEl) return;
  const summaryEl = document.getElementById('paymentSummary');
  const totalEl = document.getElementById('paymentTotal');

  if(summaryEl){
    summaryEl.innerHTML = state.cart.map(i => `
      <li class="d-flex justify-content-between align-items-center py-1 border-bottom border-opacity-10">
        <span><strong>${i.nombre}</strong> × ${i.qty}</span>
        <span class="fw-semibold text-body">$${(i.precio * i.qty).toLocaleString('es-CL')}</span>
      </li>
    `).join('');
  }

  if(totalEl){
    const sub = state.cart.reduce((a, b) => a + (b.precio * b.qty), 0);
    const tax = Math.round(sub * state.taxRate);
    totalEl.textContent = `$${(sub + tax).toLocaleString('es-CL')}`;
  }

  const modal = new bootstrap.Modal(modalEl);
  modal.show();
}