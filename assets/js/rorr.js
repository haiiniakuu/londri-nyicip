function selectCustomer() {
  const select = document.getElementById('id_customer');
  const phone = select.options[select.selectedIndex].getAttribute('data-phone');
  document.getElementById('phone').value = phone || '';
}

function openModal(service) {
  document.getElementById('modal_id').value = service.id;
  document.getElementById('modal_name').value = service.name;
  document.getElementById('modal_price').value = service.price;
  document.getElementById('modal_qty').value = service.qty;

  new bootstrap.Modal('#exampleModal').show();
}

let Cart = [];

function addToCart() {
  const id = document.getElementById('modal_id').value;
  const name = document.getElementById('modal_name').value;
  const price = parseFloat(document.getElementById('modal_price').value);
  const qty = parseFloat(document.getElementById('modal_qty').value);

  const existing = Cart.find((item) => item.id == id);
  if (existing) {
    // alert("RORRR")
    existing.qty += qty;
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
                          <small>Rp. ${item.price.toLocaleString('id-ID')}/kg</small>
                      </div>

                      <div class="d-flex align-items-center">
                          <span>${Number(item.qty).toFixed(1)}</span>
                          <button class="btn btn-danger btn-sm ms-3" onclick="removeItem(${item.id})"><i class="bi bi-trash"></i></button>
                      </div>`;
    cartContainer.appendChild(div);
  });
  updateTotal();
  calculateChange();
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
  const qty = parseFloat(document.getElementById('modal_qty').value) || 0;
  const price = parseFloat(document.getElementById('modal_price').value) || 0;

  // const subtotal = Cart.reduce((sum, item) => sum + item.price * item.qty, 0);
  const subtotal = price * qty;

  const taxValue = document.querySelector(".tax").value;
  let tax = taxValue / 100;
  console.log(tax);

  tax = subtotal * tax;
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
  const customer_id = parseInt(document.getElementById('id_customer').value);
  const end_date = document.getElementById('end_date').value;
  const pay = document.getElementById('pay').value;
  const change = document.getElementById('change').value;

  console.log({ customer_id, end_date });

  try {
    const res = await fetch('add-order.php?payment', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ Cart, order_code, subtotal, tax, grandTotal, customer_id, end_date, pay, change }),
    });
    console.log(res);

    const data = await res.json();
    console.log(data);
    if (data.status == 'success') {
      alert('transaction success');
      window.location.href = 'print.php';
    } else {
      alert('transaction failled' + data.message);
    }
  } catch (error) {
    alert('ups transaksi fail');
    console.log('error', error);
  }
}

function calculateChange() {
  const total = document.getElementById('total_value').value;
  const pay = parseFloat(document.getElementById('pay').value);

  let change = pay - total;
  if (change < 0) change = 0;
  document.getElementById('change').value = change > 0 ? change : "0";
}