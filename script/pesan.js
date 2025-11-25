function changeQty(value) {
    let qty = document.getElementById("qty");
    let current = parseInt(qty.textContent);

    let newQty = current + value;
    if (newQty < 1) newQty = 1;

    qty.textContent = newQty;
}


function toggleAcc(element) {
    const content = element.querySelector(".acc-content");
    const plus = element.querySelector(".plus");

    if (content.style.display === "block") {
        content.style.display = "none";
        plus.textContent = "+";
    } else {
        content.style.display = "block";
        plus.textContent = "−";
    }
}
