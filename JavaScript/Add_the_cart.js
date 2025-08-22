function adding() {
    const productID = getProductIDFromCookie();
    const productName = document.querySelector('h1').innerText;
    const productPrice = document.querySelector('.pc-payment').innerText.split(' ')[0];
    const productImage = document.querySelector('.pc-img').src.split('/').pop();
    const quantity = document.getElementById('quantity').value; // Get the value from the quantity input

    const data = new URLSearchParams();
    data.append('ProductID', productID);
    data.append('Pro_Name', productName);
    data.append('Price', productPrice);
    data.append('picture', productImage);
    data.append('Quantity', quantity); // Use the value from the quantity input

    fetch('../php/addToCart.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: data.toString()
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to add product to cart due to an error.');
    });
}

function getProductIDFromCookie() {
    const cookieValue = document.cookie
        .split('; ')
        .find(row => row.startsWith('pro='))
        ?.split('=')[1];
    return cookieValue;
}

function quantity_increment() {
    document.getElementById("quantity").value = Number(document.getElementById("quantity").value) + 1;
}

function quantity_decrement() {
    if (document.getElementById("quantity").value > 1) {
        document.getElementById("quantity").value = Number(document.getElementById("quantity").value) - 1;
    } else {
        alert("You cannot make the quantity less than 1");
    }
}

function inputQuantity() {
    if (!Number(document.getElementById("quantity").value) || Number(document.getElementById("quantity").value) < 1) {
        alert("Please enter a valid number");
        document.getElementById("quantity").value = 1;
    }
}
