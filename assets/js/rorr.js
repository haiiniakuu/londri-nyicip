// document.getElementById('product-title').innerHTML = "<p>Data Product di dalam halaman P</p> ";
// // document.querySelector("produch-title");
// let btn = document.getElementsByClassName("category-btn");
// btn[0].style.color = "red";
// console.log("ini button", btn);
// let buttons = document.querySelectorAll(".category-btn");
// // buttons.forEach(function (btn) ());
// buttons.forEach((btn) => {
//     btn.style.color = "violet";

//     console.log(btn);
// });

// let card = document.getelementById("card");
// let h3 = document.createElement("h3");
// let textH3 = document.createTextNode("selamatat datang");
// h3.textContent = "selamat datang dengan textcontent";

// let p = document.createElement("p");
// p.innerText = "duarrr";
// p.textContent = 'nualll';
// card.appendChild(h3);
// card.appendChild(p);


let currentCategory = "all";
function filterCategory(category, event){
    currentCategory = category;

    let buttons = document.querySelectorAll('.category-btn');
    buttons.forEach((btn) => {
        btn.classList.remove('active', 'btn-primary');
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-outline-primary');
    });
    event.classList.add('active');
    event.classList.remove('btn-outline-primary');
    event.classList.add('btn-primary');
  console.log({ currentCategory: currentCategory, category: category, event: event });
  renderProduct();
}

function renderProduct(searchProduct = "") {
  const productGrid = document.getElementById('productGrid');
  productGrid.innerHTML = "";

  //filter
  const filtered = products.filter((p) => {
    const matchCategory = currentCategory === "all" || p.category_name === currentCategory;
    const matchSearch = p.product_name.toLowerCase().includes(searchProduct) ;
    return matchCategory && matchSearch;
  })

  //muncul data dari table product
  filtered.forEach((product) => {
    const col = document.createElement('div');
    col.className = 'col-md-3 col-sm-6';
    col.innerHTML = ` 
    <div class="card product-card" onclick="addToCart(${product.id})">
      <div class="product-img">
          <img src="../${product.product_photo}" alt="">
      </div>
      <div class="card-body">
          <span class="badge bg-secondary badge-category ">${product.category_name}</span>
          <h6 class="card-title mt-2 mb-2">${product.product_name}</h6>
          <p class="card-text text-primary fw-bold">Rp. ${product.product_price}</p>
      </div>
    </div>
    `;
    productGrid.appendChild(col);
  });

  console.log(products);
}

let Cart = [];
function addToCart(id) {
  const product = products.find((p) => p.id == id);

  const existing = Cart.find((item) => item.id == id);
  if (existing) {
    // alert("RORRR")
    existing.quantity += 1;
  } else {
    Cart.push({ ...product, quantity: 1 });
  }
  renderCart();
}
function renderCart() {
  const cartContainer = document.querySelector("#cartItems");
  cartContainer.innerHTML = "";

  if (cartContainer.length === 0) {
    cartContainer.innerHTML = `
                                    <div class="text-center textmuted mt-5">
                                        <i class="bi bi-cart mb-3"></i>
                                        <p>Cart Empty</p>
                                    </div>`;
    updateTotal();
  } 
  Cart.forEach((item, index) => {
    const div = document.createElement("div");
    div.className = 'cart-item d-flex justify-content-between align-items-center mb-2';
    div.innerHTML = `
                      <div>
                          <strong>${item.product_name}</strong>
                          <small>${item.product_price}</small>
                      </div>

                      <div class="d-flex align-items-center">
                          <button class="btn btn-outline-secondary me-2" onclick="changeQty(${item.id}, -1)">-</button>
                          <span>${item.quantity}</span>
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
  item.quantity += x;
  if (item.quantity <= 0) {
    alert("minimum harus 1 produk")
    item.quantity += 1;
    // Cart.filter((p) => p.id != id);
  }
  renderCart(); 
}

function updateTotal() {
  const subtotal = Cart.reduce((sum, item) => sum + item.product_price * item.quantity, 0);
  const tax = subtotal * 0.1;
  const total = tax + subtotal;

  document.getElementById('subtotal').textContent = `Rp. ${subtotal.toLocaleString()}`;
  document.getElementById('tax').textContent = `Rp. ${tax.toLocaleString()}`;
  document.getElementById('total').textContent = `Rp. ${total.toLocaleString()}`;

  document.getElementById('subtotal_value').value = subtotal;
  document.getElementById('tax_value').value = tax;
  document.getElementById('total_value').value = total;
}

document.getElementById("clearCart").addEventListener("click",
  function (e) {
    e.preventDefault();
    Cart = [];
    renderCart(); 
  }
)

async function processPayment() {
  if (Cart.length === 0) {
    alert("cart masih ksoong");
    return;
  }

  const order_code = document.querySelector('.orderNumber').textContent.trim();
  const subtotal = document.querySelector('#subtotal_value').value.trim();
  const tax = document.querySelector('#tax_value').value.trim();
  const grandTotal = document.querySelector('#total_value').value.trim();

  try { 
    const res = await fetch('add-pos.php?payment', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ Cart, order_code, subtotal, tax, grandTotal }),
    });

    const data = await res.json();

    if (data.status == 'success') {
      alert("transaction success");
      window.location.href = "print.php";
    } else {
      alert('transaction failled' + data.message);
    }
    // console.log(res);
    
  } catch (error) {
    alert("ups transaksi fail");
    console.log("error", error);

   }
}

renderProduct();
document.getElementById('searchProduct').addEventListener('input', function (e) {
  const searchProduct = e.target.value.toLowerCase();
  console.log(searchProduct);
  renderProduct(searchProduct);

})

