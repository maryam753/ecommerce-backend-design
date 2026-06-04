<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Admin Panel – Product Management</title>
   <link rel="stylesheet" href="{{ secure_asset('css/admin.css') }}" />
 <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet"/>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a href="#" class="brand-link" onclick="return false;">
    <div class="brand-logo">
      <div class="brand-icon">
        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
      </div>
      <span class="brand-name">Brand</span>
    </div>
  </a>
 <div class="nav-stats">
  <div class="nav-stat">
    <span class="dot dot-blue"></span>
    <strong id="navTotal">0</strong>
    <span>Products</span>
  </div>
  <div class="nav-stat">
    <span class="dot dot-green"></span>
    <strong>{{ $orderCount }}</strong>  
    <span>Orders</span>
  </div>
</div>
  <div class="nav-admin">
    <div class="avatar">A</div>
    <span class="name">Admin</span>
   <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="btn-logout" type="submit">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
        <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
      </svg>
      Logout
    </button>
</form>
  </div>
</nav>

<div class="layout">
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-section">Main</div>
    <a class="sidebar-link active" id="link-products" onclick="showSection('products')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>Products
    </a>
  <a class="sidebar-link" id="link-orders" onclick="showSection('orders')">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
    <line x1="3" y1="6" x2="21" y2="6"/>
    <path d="M16 10a4 4 0 0 1-8 0"/>
  </svg>Orders
</a>
    <div class="sidebar-section">Catalog</div>
    <a class="sidebar-link" id="link-categories" onclick="showSection('categories')">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>Categories
    </a>
  </aside>

  <main class="main">

    <!-- PRODUCTS SECTION -->
    <div class="page-section active" id="section-products">
      <div class="page-header">
        <div>
          <div class="page-title">Product <span>Management</span></div>
          <div class="page-sub">Add, edit and remove products from your catalog</div>
        </div>
        <button class="btn btn-primary" onclick="openAddModal()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add Product
        </button>
      </div>

      <div class="stats-row">
        <div class="stat-card">
          <div class="stat-label">Total Products</div>
          <div class="stat-val" id="statTotal" style="color:var(--accent)">0</div>
          <div class="stat-badge">↑ 12 this month</div>
          <div class="stat-icon">📦</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Active</div>
          <div class="stat-val" id="statActive" style="color:var(--accent2)">0</div>
          <div class="stat-badge">Active products</div>
          <div class="stat-icon">✅</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Out of Stock</div>
          <div class="stat-val" id="statOOS" style="color:var(--danger)">0</div>
          <div class="stat-badge">Needs restock</div>
          <div class="stat-icon">⚠️</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Categories</div>
          <div class="stat-val" id="statCats" style="color:var(--warn)">0</div>
          <div class="stat-badge">In catalog</div>
          <div class="stat-icon">🏷️</div>
        </div>
      </div>

      <div class="toolbar">
        <div class="search-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" placeholder="Search products by name or SKU…" id="searchInput" oninput="filterTable()"/>
        </div>
        <select class="filter-select" id="catFilter" onchange="filterTable()">
          <option value="">All Categories</option>
        </select>
        <select class="filter-select" id="statusFilter" onchange="filterTable()">
          <option value="">All Status</option>
          <option>Active</option>
          <option>Inactive</option>
          <option>Out of Stock</option>
        </select>
      </div>

      <div class="table-wrap">
        <table id="productsTable">
          <thead>
            <tr>
              <th>#</th><th>Product</th><th>Category</th>
              <th>Price</th><th>Stock</th>  <th>Rating</th>
           <th>Condition</th><th>Status</th><th>Actions</th>
            </tr>
          </thead>
          <tbody id="tableBody"></tbody>
        </table>
        <div class="pagination">
          <div class="info" id="pageInfo">Showing 0 products</div>
          <div class="page-btns"><button class="page-btn active">1</button></div>
        </div>
      </div>
    </div>

    <!-- CATEGORIES SECTION -->
    <div class="page-section" id="section-categories">
      <div class="page-header">
        <div>
          <div class="page-title">Category <span>Management</span></div>
          <div class="page-sub">Organize your catalog with categories</div>
        </div>
        <button class="btn btn-primary" onclick="openAddCatModal()">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Add Category
        </button>
      </div>

      <div class="cat-stats-row">
        <div class="stat-card">
          <div class="stat-label">Total Categories</div>
          <div class="stat-val" id="catStatTotal" style="color:var(--accent)">0</div>
          <div class="stat-badge">All active</div>
          <div class="stat-icon">🏷️</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Total Products</div>
          <div class="stat-val" id="catStatProducts" style="color:var(--accent2)">0</div>
          <div class="stat-badge">Across all categories</div>
          <div class="stat-icon">📦</div>
        </div>
        <div class="stat-card">
          <div class="stat-label">Largest Category</div>
          <div class="stat-val" id="catStatLargest" style="color:var(--warn);font-size:1.1rem;padding-top:4px;">—</div>
          <div class="stat-badge">By product count</div>
          <div class="stat-icon">🏆</div>
        </div>
      </div>

      <div class="toolbar" style="margin-bottom:20px;">
        <div class="search-box">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          <input type="text" placeholder="Search categories…" id="catSearch" oninput="renderCatGrid()"/>
        </div>
      </div>

      <div class="cat-grid" id="catGrid"></div>

      <div class="table-wrap">
        <table>
          <thead>
            <tr><th>#</th><th>Category</th><th>Emoji</th><th>Products</th><th>Description</th><th>Actions</th></tr>
          </thead>
          <tbody id="catTableBody"></tbody>
        </table>
        <div class="pagination">
          <div class="info" id="catPageInfo">Showing 0 categories</div>
        </div>
      </div>
    </div>
    <!-- ORDERS SECTION -->
<div class="page-section" id="section-orders">
  <div class="page-header">
    <div>
      <div class="page-title">Order <span>Management</span></div>
      <div class="page-sub">View and manage all customer orders</div>
    </div>
  </div>

  <!-- Stats -->
  <div class="stats-row">
    <div class="stat-card">
      <div class="stat-label">Total Orders</div>
      <div class="stat-val" id="oStatTotal" style="color:var(--accent)">0</div>
      <div class="stat-icon">📦</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Pending</div>
      <div class="stat-val" id="oStatPending" style="color:var(--warn)">0</div>
      <div class="stat-icon">⏳</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Delivered</div>
      <div class="stat-val" id="oStatDelivered" style="color:var(--accent2)">0</div>
      <div class="stat-icon">✅</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Total Revenue</div>
      <div class="stat-val" id="oStatRevenue" style="color:var(--accent);font-size:1.1rem;">0</div>
      <div class="stat-icon">💰</div>
    </div>
  </div>

  <!-- Toolbar -->
  <div class="toolbar">
    <div class="search-box">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
      </svg>
      <input type="text" placeholder="Search by name, email…" id="orderSearch" oninput="filterOrders()"/>
    </div>
    <select class="filter-select" id="orderStatusFilter" onchange="filterOrders()">
      <option value="">All Status</option>
      <option>Pending</option>
      <option>Processing</option>
      <option>Shipped</option>
      <option>Delivered</option>
      <option>Cancelled</option>
    </select>
  </div>

  <!-- Table -->
  <div class="table-wrap">
    <table id="ordersTable">
      <thead>
        <tr>
          <th>#</th>
          <th>Customer</th>
          <th>Contact</th>
          <th>Items</th>
          <th>Total</th>
          <th>Payment</th>
          <th>Status</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="ordersTableBody">
        <tr><td colspan="9" style="text-align:center;padding:40px;color:var(--muted);">
          Loading orders...
        </td></tr>
      </tbody>
    </table>
    <div class="pagination">
      <div class="info" id="ordersPageInfo">Showing 0 orders</div>
    </div>
  </div>
</div>

<!-- ORDER DETAIL MODAL -->
<div class="modal-backdrop" id="orderDetailModal">
  <div class="modal" style="max-width:680px;width:95%;">
    <div class="modal-header">
      <span class="modal-title">Order Details</span>
      <button class="modal-close" onclick="closeModal('orderDetailModal')">✕</button>
    </div>
    <div class="modal-body" id="orderDetailBody"></div>
    <div class="modal-footer">
      <button class="btn btn-cancel" onclick="closeModal('orderDetailModal')">Close</button>
    </div>
  </div>
</div>

  </main>
</div>


<!-- ADD / EDIT PRODUCT MODAL -->
<div class="modal-backdrop" id="addModal">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title" id="modalTitle">Add New Product</span>
      <button type="button" class="modal-close" onclick="closeModal('addModal')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group full">
          <label class="form-label">Product Name</label>
          <input class="form-control" type="text" id="pName" placeholder="e.g. Wireless Headphones Pro" required>
        </div>
        <div class="form-group">
          <label class="form-label">SKU</label>
          <input class="form-control" type="text" id="pSku" placeholder="WHP-001" required>
        </div>
        <div class="form-group">
          <label class="form-label">Category</label>
          <select class="form-control" id="pCat"></select>
        </div>
        <div class="form-group">
          <label class="form-label">Price (PKR)</label>
          <input class="form-control" type="number" id="pPrice" placeholder="2500">
        </div>
        <div class="form-group">
          <label class="form-label">Stock Qty</label>
          <input class="form-control" type="number" id="pStock" placeholder="50">
        </div>
        <div class="form-group">
        <label class="form-label">Rating</label>
            <input
             class="form-control"
             type="number"
             id="pRating"
             min="0"
             max="5"
             step="0.1"
             placeholder="4.5">
            </div>
            <div class="form-group">
       <label class="form-label">Condition</label>
     <select class="form-control" id="pCondition">
    <option value="New">New</option>
    <option value="Used">Used</option>
    <option value="Refurbished">Refurbished</option>
        </select>
      </div>
        <div class="form-group">
          <label class="form-label">Status</label>
          <select class="form-control" id="pStatus">
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
            <option value="Out of Stock">Out of Stock</option>
          </select>
        </div>
     <div class="form-group">
  <label class="form-label">Deal Product</label>
  <input type="checkbox" id="isDeal" name="is_deal" value="1">
</div>

<div class="form-group">
  <label class="form-label">Discount Price</label>
  <input
    class="form-control"
    type="number"
    id="discountPrice"
    name="discount_price"
    placeholder="Enter Discount Price">
</div>
        <div class="form-group full">
          <label class="form-label">Description</label>
          <textarea class="form-control" id="pDesc" placeholder="Product description…"></textarea>
        </div>
        <div class="form-group full">
          <label class="form-label">Product Image</label>
          <div class="upload-zone" onclick="document.getElementById('imgFile').click()">
            📁 Click to upload image
          </div>
          <input type="file" id="imgFile" accept="image/*" style="display:none" onchange="previewImg(this)">
          <img id="imgPreview" style="display:none;max-height:100px;margin-top:10px;border-radius:8px;">
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-cancel" onclick="closeModal('addModal')">Cancel</button>
      <button type="button" class="btn btn-primary" onclick="saveProduct()">Save Product</button>
    </div>
  </div>
</div>

<!-- VIEW PRODUCT MODAL -->
<div class="modal-backdrop" id="viewModal">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">Product Details</span>
      <button type="button" class="modal-close" onclick="closeModal('viewModal')">✕</button>
    </div>
    <div class="modal-body" id="viewModalBody">
      <!-- filled by JS -->
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-cancel" onclick="closeModal('viewModal')">Close</button>
      <button type="button" class="btn btn-primary" id="viewEditBtn" onclick="">Edit Product</button>
    </div>
  </div>
</div>

<!-- VIEW CATEGORY MODAL -->
<div class="modal-backdrop" id="viewCatModal">
  <div class="modal" style="width:520px;">
    <div class="modal-header">
      <span class="modal-title">Category Details</span>
      <button type="button" class="modal-close" onclick="closeModal('viewCatModal')">✕</button>
    </div>
    <div class="modal-body" id="viewCatModalBody">
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-cancel" onclick="closeModal('viewCatModal')">Close</button>
      <button type="button" class="btn btn-primary" id="viewCatEditBtn">✏️ Edit Category</button>
    </div>
  </div>
</div>

<!-- ADD / EDIT CATEGORY MODAL -->
<div class="modal-backdrop" id="addCatModal">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title" id="catModalTitle">Add New Category</span>
      <button type="button" class="modal-close" onclick="closeModal('addCatModal')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group full">
          <label class="form-label">Category Name</label>
          <input class="form-control" type="text" id="cName" placeholder="e.g. Electronics" required>
        </div>
        <div class="form-group full">
          <label class="form-label">Description</label>
          <textarea class="form-control" id="cDesc" placeholder="Short description…" style="min-height:60px;"></textarea>
        </div>
        <div class="form-group full">
          <label class="form-label">Choose Emoji / Icon</label>
          <div class="emoji-row" id="emojiPicker"></div>
          <input type="hidden" id="selectedEmoji">
        </div>
        <div class="form-group full">
          <label class="form-label">Color Theme</label>
          <div class="color-row" id="colorPicker"></div>
          <input type="hidden" id="selectedColor">
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-cancel" onclick="closeModal('addCatModal')">Cancel</button>
      <button type="button" class="btn btn-primary" onclick="saveCategory()">Save Category</button>
    </div>
  </div>
</div>

<!-- DELETE PRODUCT MODAL -->
<div class="modal-backdrop" id="deleteModal">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">Confirm Delete</span>
      <button class="modal-close" onclick="closeModal('deleteModal')">✕</button>
    </div>
    <div class="modal-body" style="text-align:center;">
      <div class="del-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
      </div>
      <div class="modal-title" style="display:block;">Delete Product?</div>
      <p id="deleteProductName" style="color:var(--accent);font-size:.9rem;margin-top:6px;font-weight:600;"></p>
      <p style="color:var(--muted);font-size:.85rem;margin-top:6px;">This action cannot be undone. The product will be permanently removed.</p>
    </div>
    <div class="modal-footer" style="justify-content:center;">
      <button class="btn btn-cancel" onclick="closeModal('deleteModal')">Cancel</button>
      <button class="btn" style="background:var(--danger);color:#fff;" onclick="confirmDelete()">Yes, Delete</button>
    </div>
  </div>
</div>

<!-- DELETE CATEGORY MODAL -->
<div class="modal-backdrop" id="deleteCatModal">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">Confirm Delete Category</span>
      <button class="modal-close" onclick="closeModal('deleteCatModal')">✕</button>
    </div>
    <div class="modal-body" style="text-align:center;">
      <div class="del-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
      </div>
      <div class="modal-title" style="display:block;">Delete Category?</div>
      <p style="color:var(--muted);font-size:.85rem;margin-top:8px;">Products in this category will become uncategorized. This cannot be undone.</p>
    </div>
    <div class="modal-footer" style="justify-content:center;">
      <button class="btn btn-cancel" onclick="closeModal('deleteCatModal')">Cancel</button>
      <button class="btn" style="background:var(--danger);color:#fff;" onclick="confirmDeleteCat()">Yes, Delete</button>
    </div>
  </div>
</div>

<script>

//  CSRF TOKEN 
const CSRF = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';
let currentPage = 1;
const perPage = 10; 
let filteredProducts = [];
let categories = @json($categories).map(c => ({
  id:    c.id,
  name:  c.name,
  desc:  c.description ?? '',
  emoji: c.icon  ?? '🏷️',
  color: c.color ?? '#4f8cff'
}));

let products = @json($products).map(p => {
  let catName = '—';
  if (p.category && typeof p.category === 'object' && p.category.name) {
    catName = p.category.name;
  } else if (p.category_id) {
    const found = categories.find(c => c.id == p.category_id);
    catName = found ? found.name : '—';
  } else if (typeof p.category === 'string') {
    catName = p.category;
  }

  return {
    id:          p.id,
    name:        p.name        ?? 'Unnamed',
    sku:         p.sku         ?? '—',
    category:    catName,
    category_id: p.category_id ?? (p.category?.id ?? null),
    price:       p.price       ?? 0,
    stock:       p.stock       ?? 0,
    rating: p.rating ?? 0,
    condition: p.condition ?? 'New',
    status:      p.status      ?? 'Active',
    description: p.description ?? '',
    image:       p.image       ?? null,   
  };
});

//  STATE 
const CATEGORY_EMOJIS = ["🏷️","📦","👕","🎧","👛","💡","👟","🍕","📱","💻","🎮","🏠","🌿","⚽","📚","🎨","🔧","💄","🐾","🚗"];
const CATEGORY_COLORS = ["#4f8cff","#00e5a0","#ff4f6d","#ffb347","#a769ff","#00c6fb","#f9ca24","#ff6b81","#6ab04c","#e84393"];

let deleteTarget    = null;
let deleteCatTarget = null;
let editTarget      = null;   // product id being edited
let editCatTarget   = null;   // category id being edited
let selectedEmoji   = "🏷️";
let selectedColor   = "#4f8cff";

const get = id => document.getElementById(id);


//  NAVIGATION 
function showSection(section) {
  document.querySelectorAll('.page-section').forEach(s => s.classList.remove('active'));
  document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
  get('section-' + section)?.classList.add('active');
  get('link-' + section)?.classList.add('active');
  if (section === 'categories') { renderCatGrid(); renderCatTable(); updateCatStats(); }
  if (section === 'products')   { filterTable(); updateProductStats(); }
  if (section === 'orders') { loadOrders(); }
}
//  MODAL 
function openModal(id)  { get(id)?.classList.add('open'); }
function closeModal(id) {
  get(id)?.classList.remove('open');
  if (id === 'addModal')    { editTarget = null;    resetProductForm(); }
  if (id === 'addCatModal') { editCatTarget = null; resetCatForm(); }
}
document.querySelectorAll('.modal-backdrop').forEach(bd => {
  bd.addEventListener('click', e => { if (e.target === bd) bd.classList.remove('open'); });
});
//  PRODUCT: VIEW 
function viewProduct(id) {
  const p = products.find(x => x.id == id);
  if (!p) return;
 
  const imgHtml = p.image
    ? `<img src="/storage/${p.image}" alt="${p.name}">`
    : `<span style="font-size:2rem;">📦</span>`;
 
  get('viewModalBody').innerHTML = `
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px;">
      <div class="view-img-box">${imgHtml}</div>
      <div>
        <div style="font-family:var(--font-head);font-size:1.1rem;font-weight:700;">${p.name}</div>
        <div style="color:var(--muted);font-size:0.78rem;margin-top:3px;">SKU: ${p.sku}</div>
      </div>
    </div>
    <div class="view-detail-row">
      <span class="view-detail-label">Category</span>
      <span class="view-detail-val"><span class="badge badge-blue">${p.category}</span></span>
    </div>
    <div class="view-detail-row">
      <span class="view-detail-label">Price</span>
      <span class="view-detail-val" style="color:var(--accent2);font-weight:700;">
        PKR ${Number(p.price).toLocaleString()}
      </span>
    </div>
    <div class="view-detail-row">
      <span class="view-detail-label">Stock</span>
      <span class="view-detail-val" style="${p.stock==0?'color:var(--danger)':''}">
        ${p.stock} units
      </span>
    </div>
    <div class="view-detail-row">
      <span class="view-detail-label">Status</span>
      <span class="view-detail-val">${statusBadge(p.status)}</span>
    </div>
    ${p.description ? `
    <div class="view-detail-row" style="flex-direction:column;align-items:flex-start;gap:6px;">
      <span class="view-detail-label">Description</span>
      <span style="color:var(--muted);font-size:0.83rem;line-height:1.5;">${p.description}</span>
    </div>` : ''}
  `;
 
  get('viewEditBtn').onclick = () => { closeModal('viewModal'); editProduct(id); };
  openModal('viewModal');
}

//  PRODUCT: EDIT 
function editProduct(id) {
  const p = products.find(x => x.id == id);
  if (!p) return;
 
  editTarget = id;
  populatePCat(p.category_id);
 
  get('pName').value   = p.name;
  get('pSku').value    = p.sku;
  get('pPrice').value  = p.price;
  get('pStock').value  = p.stock;
  get('pRating').value = p.rating || 0;
  get('pCondition').value = p.condition || 'New';
  get('pStatus').value = p.status;
  get('pDesc').value   = p.description || '';
 
  if (p.image) {
    const img = get('imgPreview');
    img.src = `/storage/${p.image}`;
    img.style.display = 'block';
  }
 
  get('modalTitle').textContent = 'Edit Product';
  openModal('addModal');
}
function saveProduct() {
  const name   = get('pName').value.trim();
  const sku    = get('pSku').value.trim();
  const catId  = get('pCat').value;
  const price  = get('pPrice').value;
  const stock  = get('pStock').value;
  const rating = get('pRating').value;
  const condition = get('pCondition').value;
  const status = get('pStatus').value;
  const desc   = get('pDesc').value.trim();
  const imgFile = get('imgFile').files[0];

const isDeal = document.getElementById('isDeal')?.checked ?? false;
const discountPrice = get('discountPrice').value;
  if (!name || !sku) {
    showToast('Name and SKU are required', 'error');
    return;
  }

  const formData = new FormData();
  formData.append('_token', CSRF);
  formData.append('name', name);
  formData.append('sku', sku);
  formData.append('category_id', catId);
  formData.append('price', price);
  formData.append('stock', stock);
  formData.append('rating', rating);
  formData.append('condition', condition);
  formData.append('status', status);
  formData.append('description', desc);
formData.append('is_deal', isDeal ? 1 : 0);
if (discountPrice !== '') {
  formData.append('discount_price', discountPrice);
}
  if (imgFile) formData.append('image', imgFile);

  const url = editTarget
    ? `/product/${editTarget}/update`
    : `/product/store`;

 fetch(url, {
  method: 'POST',
  headers: {
    'X-CSRF-TOKEN': CSRF,
    'Accept': 'application/json',
    'X-Requested-With': 'XMLHttpRequest'
  },
  body: formData
})
.then(async res => {

  const data = await res.json();

  if (!res.ok) {
    console.log("Validation Error:", data);
    throw data; // important
  }

  return data;
})
.then(data => {

  const p = data.product ?? data;

  const foundCategory = categories.find(c => c.id == p.category_id);

  const newProduct = {
    id: p.id,
    name: p.name,
    sku: p.sku,
    category: foundCategory ? foundCategory.name : '—',
    category_id: p.category_id,
    price: p.price,
    stock: p.stock,
    rating: p.rating ?? 0,
    condition: p.condition ?? 'New',
    status: p.status,
    description: p.description ?? '',
    image: p.image ?? null
  };

  if (editTarget) {

    const index = products.findIndex(x => x.id == editTarget);

    if (index !== -1) {
      products[index] = newProduct;
    }

  } else {

    products.unshift(newProduct); // new product top pe show hoga

  }

  showToast(
    editTarget ? 'Product updated!' : 'Product added!',
    'success'
  );

  closeModal('addModal');

  filterTable();
  updateProductStats();
})
.catch(err => {
  console.log("FULL ERROR:", err);

  const msg = err?.errors
    ? Object.values(err.errors).flat().join(', ')
    : err?.message || 'Something went wrong';

  alert(msg);
});
}
//  PRODUCT: DELETE 
function askDelete(id) {
  const p = products.find(x => x.id == id);
  deleteTarget = id;
  const nameEl = get('deleteProductName');
  if (nameEl) nameEl.textContent = p ? `"${p.name}"` : '';
  openModal('deleteModal');
}
function confirmDelete() {
  if (!deleteTarget) return;
  const id = deleteTarget;
  closeModal('deleteModal');
 
  fetch(`/product/${id}`, {         
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN':    CSRF,
      'Accept':          'application/json',
      'X-Requested-With':'XMLHttpRequest'
    }
  })
  .then(res => {
    if (!res.ok) throw new Error('Delete failed — status: ' + res.status);
    return res.json();
  })
  .then(() => {
    products = products.filter(p => p.id != id);
    deleteTarget = null;
    filterTable();
    updateProductStats();
    showToast('Product deleted', 'error');
  })
  .catch(err => {
    console.error(err);
    showToast('Delete failed. ', 'error');
  });
}
function openAddModal() {
  editTarget = null;
  resetProductForm();
  populatePCat();
  get('modalTitle').textContent = 'Add New Product';
  openModal('addModal');
}

function resetProductForm() {
  ['pName','pSku','pPrice','pStock','pDesc'].forEach(id => {
    const el = get(id); if (el) el.value = '';
  });
  const img = get('imgPreview');
  if (img) { img.style.display = 'none'; img.src = ''; }
  const fi = get('imgFile');
  if (fi) fi.value = '';
  get('pStatus').value = 'Active';
  get('pRating').value = '';
get('pCondition').value = 'New';
document.getElementById('isDeal').checked = false;
document.getElementById('discountPrice').value = '';
}

function previewImg(input) {
  const file = input.files?.[0]; if (!file) return;
  const reader = new FileReader();
  reader.onload = e => {
    const img = get('imgPreview');
    if (!img) return;
    img.src = e.target.result;
    img.style.display = 'block';
  };
  reader.readAsDataURL(file);
}

//  PRODUCT: TABLE 
function statusBadge(s) {
  const map = { Active:'badge-green', Inactive:'badge-red', 'Out of Stock':'badge-warn' };
  return `<span class="badge ${map[s]||'badge-blue'}">${s}</span>`;
}

function updateProductStats() {
  get('statTotal').textContent  = products.length;
  get('statActive').textContent = products.filter(p => p.status === 'Active').length;
  get('statOOS').textContent    = products.filter(p => p.status === 'Out of Stock').length;
  get('statCats').textContent   = categories.length;
  get('navTotal').textContent   = products.length;
}

function renderTable(data) {
  const tbody = get('tableBody');
  if (!tbody) return;

  const totalPages = Math.ceil(data.length / perPage);
  if (currentPage > totalPages) currentPage = 1;

  const start = (currentPage - 1) * perPage;
  const paginatedData = data.slice(start, start + perPage);

  if (!paginatedData.length) {
    tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;color:var(--muted);padding:32px;">No products found.</td></tr>`;
    get('pageInfo').textContent = 'No products';
    return;
  }

  tbody.innerHTML = paginatedData.map((p, i) => {
    const imgContent = p.image
      ? `<img src="/storage/${p.image}" style="width:100%;height:100%;object-fit:cover;border-radius:8px;">`
      : `<span style="font-size:1.3rem;">📦</span>`;

    return `
    <tr>
      <td>${start + i + 1}</td>
      <td>
        <div class="product-cell">
          <div class="product-img">${imgContent}</div>
          <div>
            <div class="product-name">${p.name}</div>
            <div class="product-sku">${p.sku}</div>
          </div>
        </div>
      </td>
      <td><span class="badge badge-blue">${p.category}</span></td>
      <td><strong>PKR ${Number(p.price).toLocaleString()}</strong></td>
      <td>${p.stock}</td>
      <td>${p.rating} ★</td>
       <td><span class="badge badge-blue"> ${p.condition} </span></td>
      <td>${statusBadge(p.status)}</td>
      <td>
        <div class="actions">
          <button onclick="viewProduct(${p.id})">👁</button>
          <button onclick="editProduct(${p.id})">✏️</button>
          <button onclick="askDelete(${p.id})">🗑</button>
        </div>
      </td>
    </tr>`;
  }).join('');

  get('pageInfo').textContent =
    `Page ${currentPage} of ${totalPages} | Showing ${start + 1}-${start + paginatedData.length} of ${data.length}`;

  renderPagination(totalPages);
}
function renderPagination(totalPages) {
  const container = document.querySelector('.page-btns');

  let html = '';

  for (let i = 1; i <= totalPages; i++) {
    html += `<button class="page-btn ${i === currentPage ? 'active' : ''}" 
      onclick="goToPage(${i})">${i}</button>`;
  }

  container.innerHTML = html;
}
function goToPage(page) {
  currentPage = page;
  renderTable(filteredProducts); 
}

function filterTable() {
  const q   = (get('searchInput')?.value || '').toLowerCase();
  const cat = get('catFilter')?.value || '';
  const st  = get('statusFilter')?.value || '';

  filteredProducts = products.filter(p =>
    (p.name.toLowerCase().includes(q) || p.sku.toLowerCase().includes(q)) &&
    (!cat || p.category === cat) &&
    (!st  || p.status === st)
  );

  currentPage = 1;
  renderTable(filteredProducts);
}
function populateCatFilter() {
  const sel = get('catFilter'); if (!sel) return;
  const cur = sel.value;
  sel.innerHTML = '<option value="">All Categories</option>' +
    categories.map(c => `<option ${c.name === cur ? 'selected' : ''}>${c.name}</option>`).join('');
}

function populatePCat(selectedCatId = null) {
  const sel = get('pCat'); if (!sel) return;
  sel.innerHTML = categories.map(c =>
    `<option value="${c.id}" ${c.id == selectedCatId ? 'selected' : ''}>${c.name}</option>`
  ).join('');
}

//  CATEGORIES 
function productCountFor(catName) {
  return products.filter(p => p.category === catName).length;
}

function updateCatStats() {
  get('catStatTotal').textContent    = categories.length;
  get('catStatProducts').textContent = products.length;
  const largest = categories.length
    ? categories.reduce((a, b) => productCountFor(a.name) >= productCountFor(b.name) ? a : b)
    : null;
  get('catStatLargest').textContent = largest ? `${largest.emoji} ${largest.name}` : '—';
}

function renderCatGrid() {
  const q = (get('catSearch')?.value || '').toLowerCase();
  const filtered = categories.filter(c =>
    c.name.toLowerCase().includes(q) || c.desc.toLowerCase().includes(q)
  );
  const grid = get('catGrid'); if (!grid) return;
  if (!filtered.length) {
    grid.innerHTML = `<p style="color:var(--muted);grid-column:1/-1;">No categories found.</p>`;
    return;
  }
  grid.innerHTML = filtered.map(c => `
    <div class="cat-card" style="--cat-color:${c.color}">
      <div class="cat-icon-box" style="--cat-color:${c.color}">${c.emoji}</div>
      <div class="cat-info">
        <div class="cat-name">${c.name}</div>
        <div class="cat-meta">${productCountFor(c.name)} products · ${c.desc || 'No description'}</div>
      </div>
      <div class="cat-actions">
        <button class="action-btn edit"   title="Edit"   onclick="editCategory(${c.id})">✏️</button>
        <button class="action-btn delete" title="Delete" onclick="askDeleteCat(${c.id})">🗑</button>
      </div>
    </div>`).join('');

  renderCatTable();
}

function renderCatTable() {
  const q = (get('catSearch')?.value || '').toLowerCase();
  const filtered = categories.filter(c => c.name.toLowerCase().includes(q));
  const tbody = get('catTableBody'); if (!tbody) return;
  tbody.innerHTML = filtered.map((c, i) => `
    <tr>
      <td style="color:var(--muted);font-size:.78rem;">${String(i+1).padStart(2,'0')}</td>
      <td>
        <div style="display:flex;align-items:center;gap:8px;">
          <span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:${c.color};"></span>
          <strong>${c.name}</strong>
        </div>
      </td>
      <td style="font-size:1.2rem;">${c.emoji}</td>
      <td><span class="badge badge-blue">${productCountFor(c.name)} products</span></td>
      <td style="color:var(--muted);font-size:.82rem;">${c.desc && c.desc.trim() ? c.desc : '—'}</td>
      <td>
      <div class="actions">
  <button class="action-btn view"  onclick="viewCategory('${c.id}')"> 👁 </button>
  <button class="action-btn edit"onclick="editCategory('${c.id}')">✏️</button>
  <button class="action-btn delete"onclick="askDeleteCat('${c.id}')">🗑</button>
</div>
      </td>
    </tr>`).join('');
  const pi = get('catPageInfo');
  if (pi) pi.textContent = `Showing ${filtered.length} of ${categories.length} categories`;
}

//  CATEGORY: EMOJI & COLOR PICKERS 
function buildEmojiPicker(current) {
  selectedEmoji = current || CATEGORY_EMOJIS[0];
  get('selectedEmoji').value = selectedEmoji;
  get('emojiPicker').innerHTML = CATEGORY_EMOJIS.map(e =>
    `<div class="emoji-opt${e === selectedEmoji ? ' selected' : ''}" onclick="selectEmoji('${e}',this)">${e}</div>`
  ).join('');
}
function selectEmoji(e, el) {
  selectedEmoji = e;
  get('selectedEmoji').value = e;
  document.querySelectorAll('.emoji-opt').forEach(x => x.classList.remove('selected'));
  el.classList.add('selected');
}
function buildColorPicker(current) {
  selectedColor = current || CATEGORY_COLORS[0];
  get('selectedColor').value = selectedColor;
  get('colorPicker').innerHTML = CATEGORY_COLORS.map(c =>
    `<div class="color-swatch${c === selectedColor ? ' selected' : ''}"
      style="background:${c}" onclick="selectColor('${c}',this)" title="${c}"></div>`
  ).join('');
}
function selectColor(c, el) {
  selectedColor = c;
  get('selectedColor').value = c;
  document.querySelectorAll('.color-swatch').forEach(x => x.classList.remove('selected'));
  el.classList.add('selected');
}

//  CATEGORY: SAVE 
function openAddCatModal() {
  editCatTarget = null;
  resetCatForm();
  get('catModalTitle').textContent = 'Add New Category';
  openModal('addCatModal');
}

function resetCatForm() {
  ['cName','cDesc'].forEach(id => { const el = get(id); if (el) el.value = ''; });
  buildEmojiPicker();
  buildColorPicker();
}
function viewCategory(id) {
  const c = categories.find(x => x.id == id);
  if (!c) return;
 
  const catProducts = products.filter(p => p.category === c.name);
 
  // Products ki list HTML
  const prodListHtml = catProducts.length
    ? catProducts.map(p => `
        <div style="display:flex;align-items:center;justify-content:space-between;
           padding:10px 0;border-bottom:1px solid var(--border);">
          <div>
            <div style="font-size:0.85rem;font-weight:500;">${p.name}</div>
            <div style="font-size:0.72rem;color:var(--muted);">SKU: ${p.sku}</div>
          </div>
          <div style="display:flex;align-items:center;gap:8px;">
            <span style="font-size:0.82rem;color:var(--accent2);font-weight:600;">
              PKR ${Number(p.price).toLocaleString()}
            </span>
            ${statusBadge(p.status)}
          </div>
        </div>`).join('')
    : `<p style="color:var(--muted);font-size:0.83rem;padding:12px 0;text-align:center;">
         📭 there is no product in this category.
       </p>`;
 
  document.getElementById('viewCatModalBody').innerHTML = `
    <div style="border-radius:12px;padding:20px;display:flex;align-items:center;
                gap:16px;margin-bottom:20px;position:relative;overflow:hidden;
                background:${c.color}11;border:1px solid ${c.color}33;">
      <div style="position:absolute;top:0;left:0;right:0;height:3px;background:${c.color};"></div>
      <div style="width:64px;height:64px;border-radius:14px;background:${c.color}22;
                  border:1px solid ${c.color}44;display:flex;align-items:center;
                  justify-content:center;font-size:2rem;flex-shrink:0;">
        ${c.emoji}
      </div>
      <div>
        <div style="font-family:var(--font-head);font-size:1.2rem;font-weight:800;">${c.name}</div>
        <div style="color:var(--muted);font-size:0.82rem;margin-top:4px;">
          ${c.desc || 'Koi description nahi'}
        </div>
      </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:20px;">
      <div style="background:var(--card);border:1px solid var(--border);border-radius:10px;
                  padding:12px;text-align:center;">
        <div style="font-family:var(--font-head);font-size:1.5rem;font-weight:800;color:var(--accent);">
          ${catProducts.length}
        </div>
        <div style="font-size:0.7rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;">
          Products
        </div>
      </div>
      <div style="background:var(--card);border:1px solid var(--border);border-radius:10px;
                  padding:12px;text-align:center;">
        <div style="font-size:1.6rem;">${c.emoji}</div>
        <div style="font-size:0.7rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;">Icon</div>
      </div>
      <div style="background:var(--card);border:1px solid var(--border);border-radius:10px;
                  padding:12px;text-align:center;">
        <div style="width:22px;height:22px;border-radius:50%;background:${c.color};margin:0 auto 4px;"></div>
        <div style="font-size:0.7rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;">
          ${c.color}
        </div>
      </div>
    </div>
 

    <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
      <span style="font-size:0.75rem;color:var(--muted);font-weight:600;text-transform:uppercase;">ID</span>
      <span style="font-size:0.85rem;color:var(--muted);">#${c.id}</span>
    </div>
    <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
      <span style="font-size:0.75rem;color:var(--muted);font-weight:600;text-transform:uppercase;">Name</span>
      <span style="font-size:0.85rem;font-weight:700;">${c.name}</span>
    </div>
    <div style="display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
      <span style="font-size:0.75rem;color:var(--muted);font-weight:600;text-transform:uppercase;">Total Products</span>
      <span class="badge badge-blue">${catProducts.length} products</span>
    </div>
 
    {{-- Products list --}}
    ${catProducts.length > 0 ? `
    <div style="margin-top:16px;">
      <div style="font-size:0.75rem;font-weight:700;letter-spacing:1px;
                  text-transform:uppercase;color:var(--muted);margin-bottom:8px;">
       products of this category
      </div>
      ${prodListHtml}
    </div>` : prodListHtml}
  `;
   document.getElementById('viewCatEditBtn').onclick = () => {
    closeModal('viewCatModal');
    editCategory(id);
  };
 
  openModal('viewCatModal');
}
function editCategory(id) {
  const c = categories.find(x => x.id == id);
  if (!c) return;
 
  editCatTarget = id;
 
  get('catModalTitle').textContent = 'Edit Category';
  get('cName').value = c.name;
  get('cDesc').value = c.desc || '';
 
  buildEmojiPicker(c.emoji);
  buildColorPicker(c.color);
 
  openModal('addCatModal');
}
function saveCategory() {

  const name = get('cName')?.value.trim();
  const desc = get('cDesc')?.value.trim();

  if (!name) {
    showToast('Category name required', 'error');
    return;
  }

  const formData = new FormData();
  formData.append('_token', CSRF);
  formData.append('name', name);
  formData.append('description', desc);
  formData.append('icon', selectedEmoji);
  formData.append('color', selectedColor);

  let url = '/category/store';

  // UPDATE
  if (editCatTarget) {
    formData.append('_method', 'PUT');
    url = `/categories/${editCatTarget}`;
  }

  fetch(url, {
    method: 'POST',
    headers: {
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
  })
  .then(async res => {

    const data = await res.json();

    if (!res.ok) {
      throw data;
    }

    return data;
  })
  .then(data => {

    const c = data.category ?? data;

    const normalized = {
      id: c.id,
      name: c.name,
      desc: c.description ?? '',
      emoji: c.icon ?? '🏷️',
      color: c.color ?? '#4f8cff'
    };

    // UPDATE
    if (editCatTarget) {

      const idx = categories.findIndex(x => x.id == editCatTarget);

      if (idx !== -1) {
        categories[idx] = normalized;
      }

      showToast('Category updated!', 'success');

    } else {

      // ADD
      categories.push(normalized);

      showToast('Category added!', 'success');
    }

    closeModal('addCatModal');

    renderCatGrid();
    renderCatTable();
    updateCatStats();
    populateCatFilter();
    populatePCat();
    updateProductStats();
  })
  .catch(err => {

    console.error(err);

    const msg = err?.errors
      ? Object.values(err.errors).flat().join(', ')
      : 'Save failed';

    showToast(msg, 'error');
  });
}
//  CATEGORY: DELETE 
function askDeleteCat(id) {
  deleteCatTarget = id;
  openModal('deleteCatModal');
}

function confirmDeleteCat() {
  if (!deleteCatTarget) return;
  const id = deleteCatTarget;
  const cat = categories.find(c => c.id == id);
  closeModal('deleteCatModal');
 
  fetch(`/categories/${id}`, {
    method: 'DELETE',
    headers: {
      'X-CSRF-TOKEN':     CSRF,         
      'Accept':           'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(res => {
    if (!res.ok) throw new Error('Delete failed: ' + res.status);
    return res.json();
  })
  .then(() => {
    categories = categories.filter(c => c.id != id);
    deleteCatTarget = null;
 
    renderCatGrid();
    renderCatTable();
    updateCatStats();
    populateCatFilter();
    populatePCat();
 
    showToast(`"${cat?.name || 'Category'}" deleted`, 'error');
  })
  .catch(err => {
    console.error(err);
    showToast('Delete failed. Console check karo.', 'error');
  });
}

//  TOAST 
function showToast(msg, type = 'success') {
  const t = document.createElement('div');
  t.className = `toast ${type}`;
  t.innerHTML = `<span>${type === 'success' ? '✅' : '❌'}</span><span>${msg}</span>`;
  document.body.appendChild(t);
  setTimeout(() => t.remove(), 3500);
}
//  ORDERS 
let allOrders = [];
let filteredOrders = [];

function orderStatusBadge(s) {
  const map = {
    'Pending':    'badge-warn',
    'Processing': 'badge-blue',
    'Shipped':    'badge-blue',
    'Delivered':  'badge-green',
    'Cancelled':  'badge-red'
  };
  return `<span class="badge ${map[s] || 'badge-blue'}">${s}</span>`;
}

function loadOrders() {
  fetch('/admin/orders', {
    headers: {
      'Accept': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    }
  })
  .then(res => res.json())
  .then(data => {
    allOrders = data;
    filteredOrders = data;
    renderOrdersTable(filteredOrders);
    updateOrderStats(filteredOrders);
  })
  .catch(err => {
    console.error(err);
    document.getElementById('ordersTableBody').innerHTML =
      `<tr><td colspan="9" style="text-align:center;color:var(--danger);padding:30px;">
        Failed to load orders.
      </td></tr>`;
  });
}

function updateOrderStats(data) {
  document.getElementById('oStatTotal').textContent     = data.length;
  document.getElementById('oStatPending').textContent   = data.filter(o => o.status === 'Pending').length;
  document.getElementById('oStatDelivered').textContent = data.filter(o => o.status === 'Delivered').length;
  const revenue = data.reduce((sum, o) => sum + parseFloat(o.total || 0), 0);
  document.getElementById('oStatRevenue').textContent   = 'PKR ' + Number(revenue).toLocaleString();
}

function filterOrders() {
  const q  = document.getElementById('orderSearch').value.toLowerCase();
  const st = document.getElementById('orderStatusFilter').value;

  filteredOrders = allOrders.filter(o =>
    (!q  || o.name?.toLowerCase().includes(q) || o.email?.toLowerCase().includes(q)) &&
    (!st || o.status === st)
  );
  renderOrdersTable(filteredOrders);
  updateOrderStats(filteredOrders);
}

function renderOrdersTable(data) {
  const tbody = document.getElementById('ordersTableBody');

  if (!data.length) {
    tbody.innerHTML = `<tr><td colspan="9" style="text-align:center;padding:32px;color:var(--muted);">
      No orders found.
    </td></tr>`;
    document.getElementById('ordersPageInfo').textContent = 'No orders';
    return;
  }

  tbody.innerHTML = data.map((o, i) => `
    <tr>
      <td style="color:var(--muted);font-size:.78rem;">#${o.id}</td>
      <td>
        <div style="font-weight:600;font-size:.85rem;">${o.name}</div>
        <div style="font-size:.72rem;color:var(--muted);">${o.city}, ${o.country}</div>
      </td>
      <td>
        <div style="font-size:.78rem;">${o.email}</div>
        <div style="font-size:.78rem;color:var(--muted);">${o.phone}</div>
      </td>
      <td><span class="badge badge-blue">${o.items?.length || 0} items</span></td>
      <td><strong>PKR ${Number(o.total).toLocaleString()}</strong></td>
      <td style="font-size:.82rem;">${o.payment_method}</td>
      <td>${orderStatusBadge(o.status)}</td>
      <td style="font-size:.78rem;color:var(--muted);">
        ${new Date(o.created_at).toLocaleDateString('en-PK')}
      </td>
      <td>
        <div class="actions">
          <button onclick="viewOrder(${o.id})" title="View">👁</button>
        </div>
      </td>
    </tr>
  `).join('');

  document.getElementById('ordersPageInfo').textContent =
    `Showing ${data.length} of ${allOrders.length} orders`;
}

function viewOrder(id) {
  const o = allOrders.find(x => x.id == id);
  if (!o) return;

  const itemsHtml = o.items?.length
    ? o.items.map(item => `
        <div style="display:flex;justify-content:space-between;align-items:center;
                    padding:10px 0;border-bottom:1px solid var(--border);">
          <div>
            <div style="font-size:.85rem;font-weight:600;">
              ${item.product?.name || 'Product #' + item.product_id}
            </div>
            <div style="font-size:.72rem;color:var(--muted);">Qty: ${item.qty}</div>
          </div>
          <div style="font-weight:700;color:var(--accent2);">
            PKR ${Number(item.price * item.qty).toLocaleString()}
          </div>
        </div>`).join('')
    : `<p style="color:var(--muted);font-size:.83rem;">No items found.</p>`;

  document.getElementById('orderDetailBody').innerHTML = `
    <!-- Customer Info -->
    <div style="background:var(--bg);border-radius:10px;padding:16px;margin-bottom:16px;">
      <div style="font-size:.7rem;font-weight:700;letter-spacing:1px;
                  text-transform:uppercase;color:var(--muted);margin-bottom:10px;">
        Customer Info
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:8px;">
        <div><span style="color:var(--muted);font-size:.75rem;">Name</span>
          <div style="font-weight:600;font-size:.85rem;">${o.name}</div></div>
        <div><span style="color:var(--muted);font-size:.75rem;">Email</span>
          <div style="font-size:.85rem;">${o.email}</div></div>
        <div><span style="color:var(--muted);font-size:.75rem;">Phone</span>
          <div style="font-size:.85rem;">${o.phone}</div></div>
        <div><span style="color:var(--muted);font-size:.75rem;">City</span>
          <div style="font-size:.85rem;">${o.city}, ${o.country}</div></div>
        <div style="grid-column:1/-1;">
          <span style="color:var(--muted);font-size:.75rem;">Address</span>
          <div style="font-size:.85rem;">${o.address}</div>
        </div>
      </div>
    </div>

    <!-- Order Items -->
    <div style="margin-bottom:16px;">
      <div style="font-size:.7rem;font-weight:700;letter-spacing:1px;
                  text-transform:uppercase;color:var(--muted);margin-bottom:10px;">
        Order Items
      </div>
      ${itemsHtml}
      <div style="display:flex;justify-content:flex-end;margin-top:10px;">
        <strong>Total: PKR ${Number(o.total).toLocaleString()}</strong>
      </div>
    </div>

    <!-- Payment & Shipping -->
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
      <div style="background:var(--bg);border-radius:10px;padding:12px;">
        <div style="font-size:.7rem;color:var(--muted);text-transform:uppercase;">Payment</div>
        <div style="font-weight:600;margin-top:4px;">${o.payment_method}</div>
      </div>
      <div style="background:var(--bg);border-radius:10px;padding:12px;">
        <div style="font-size:.7rem;color:var(--muted);text-transform:uppercase;">Shipping</div>
        <div style="font-weight:600;margin-top:4px;">${o.shipping_method}</div>
      </div>
    </div>

    <!-- Status Update -->
    <div style="background:var(--bg);border-radius:10px;padding:16px;">
      <div style="font-size:.7rem;font-weight:700;letter-spacing:1px;
                  text-transform:uppercase;color:var(--muted);margin-bottom:10px;">
        Update Status
      </div>
      <div style="display:flex;gap:10px;align-items:center;">
        <select id="newOrderStatus" class="form-control" style="flex:1;">
          <option ${o.status==='Pending'    ? 'selected':''}>Pending</option>
          <option ${o.status==='Processing' ? 'selected':''}>Processing</option>
          <option ${o.status==='Shipped'    ? 'selected':''}>Shipped</option>
          <option ${o.status==='Delivered'  ? 'selected':''}>Delivered</option>
          <option ${o.status==='Cancelled'  ? 'selected':''}>Cancelled</option>
        </select>
        <button class="btn btn-primary" onclick="updateOrderStatus(${o.id})">
          Update
        </button>
      </div>
    </div>
  `;

  openModal('orderDetailModal');
}

function updateOrderStatus(id) {
  const status = document.getElementById('newOrderStatus').value;

  fetch(`/admin/orders/${id}/status`, {
    method: 'PATCH',
    headers: {
      'Content-Type':     'application/json',
      'X-CSRF-TOKEN':     CSRF,
      'Accept':           'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: JSON.stringify({ status })
  })
  .then(res => res.json())
  .then(() => {
    // Local update
    const idx = allOrders.findIndex(o => o.id == id);
    if (idx !== -1) allOrders[idx].status = status;

    closeModal('orderDetailModal');
    filterOrders();
    showToast('Order status updated!', 'success');
  })
  .catch(err => {
    console.error(err);
    showToast('Update failed', 'error');
  });
}


//  INIT 
document.addEventListener('DOMContentLoaded', () => {
  populateCatFilter();
  populatePCat();
  buildEmojiPicker();
  buildColorPicker();
  filterTable();
  updateProductStats();
});

</script>
</body>
</html>