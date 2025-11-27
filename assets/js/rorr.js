function selectCustomer() {
  const select = document.getElementById('id_customer');
  const phone = select.options[select.selectedIndex].getAttribute('data-phone');
  document.getElementById('phone').value = phone || '';
}

function openModal(service) {
  document.getElementById('modal_id').value = service.id;
  document.getElementById('modal_name').value = service.name;
  document.getElementById('modal_price').value = service.price;
  document.getElementById('modal_qty').value = 1;

  new bootstrap.Modal('#exampleModal').show();
}

let Cart = [];

function addToCart() {
  const id = document.getElementById('modal_id').value;
  const name = document.getElementById('modal_name').value;
  const price = parseInt(document.getElementById('modal_price').value);
  const qty = parseInt(document.getElementById('modal_qty').value);

  const existing = Cart.find((item) => item.id == id);
  if (existing) {
    // alert("RORRR")
    existing.quantity += qty;
  } else {
    Cart.push({
      id,
      name,
      price,
      qty,
    });
  }
  renderCart();
}

function renderCart() {
  const cartContainer = document.querySelector('#cartItems');
  cartContainer.innerHTML = '';

  if (cartContainer.length === 0) {
    cartContainer.innerHTML = `
                                    <div class="text-center textmuted mt-5">
                                        <i class="bi bi-cart mb-3"></i>
                                        <p>Cart Empty</p>
                                    </div>`;
    updateTotal();
  }
  Cart.forEach((item, index) => {
    const div = document.createElement('div');
    div.className = 'cart-item d-flex justify-content-between align-items-center mb-2';
    div.innerHTML = `
                      <div>
                          <strong>${item.name}</strong>
                          <small>Rp. ${item.price.toLocaleString('id-ID')}</small>
                      </div>

                      <div class="d-flex align-items-center">
                          <button class="btn btn-outline-secondary me-2" onclick="changeQty(${item.id}, -1)">-</button>
                          <span>${item.qty}</span>
                          <button class="btn btn-outline-secondary ms-3" onclick="changeQty(${item.id}, 1)">+</button>
                          <button class="btn btn-danger btn-sm ms-3" onclick="removeItem(${item.id})"><i class="bi bi-trash"></i></button>
                      </div>`;
    cartContainer.appendChild(div);
  });
  updateTotal();
}

function removeItem(id) {
  Cart = Cart.filter((p) => p.id != id);
  renderCart();
}

function changeQty(id, x) {
  const item = Cart.find((p) => p.id == id);
  if (!item) {
    return;
  }
  item.qty += x;
  if (item.qty <= 0) {
    alert('minimum harus 1 produk');
    item.qty += 1;
    // Cart.filter((p) => p.id != id);
  }
  renderCart();
}

function updateTotal() {
  const subtotal = Cart.reduce((sum, item) => sum + item.price * item.qty, 0);
  const tax = subtotal * 0.1;
  const total = tax + subtotal;

  document.getElementById('subtotal').textContent = `Rp. ${subtotal.toLocaleString()}`;
  document.getElementById('tax').textContent = `Rp. ${tax.toLocaleString()}`;
  document.getElementById('total').textContent = `Rp. ${total.toLocaleString()}`;

  document.getElementById('subtotal_value').value = subtotal;
  document.getElementById('tax_value').value = tax;
  document.getElementById('total_value').value = total;
}

document.getElementById('clearCart').addEventListener('click', function (e) {
  e.preventDefault();
  Cart = [];
  renderCart();
});

async function processPayment() {
  if (Cart.length === 0) {
    alert('cart masih kosong');
    return;
  }

  const order_code = document.querySelector('.orderNumber').textContent.trim();
  const subtotal = document.querySelector('#subtotal_value').value.trim();
  const tax = document.querySelector('#tax_value').value.trim();
  const grandTotal = document.querySelector('#total_value').value.trim();
  const customer_id = document.getElementById('id_customer').value;
  const end_date = document.getElementById('end_date').value;

  try {
    const res = await fetch('add-order.php?payment', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ Cart, order_code, subtotal, tax, grandTotal, customer_id, end_date }),
    });

    const data = await res.json();

    if (data.status == 'success') {
      alert('transaction success');
      window.location.href = 'print.php';
    } else {
      alert('transaction failled' + data.message);
    }
    // console.log(res);
  } catch (error) {
    alert('ups transaksi fail');
    console.log('error', error);
  }
}