function updateTotalPrice() {
    const select = document.getElementById('event-selector');
    const pricePerTicket = parseFloat(select.options[select.selectedIndex].getAttribute('data-price'));
    const quantity = document.getElementById('ticket-quantity').value;
    const totalPrice = pricePerTicket * quantity;
    document.getElementById('total-price').innerText = `Total Price: ${totalPrice.toFixed(2)} €`;
}

let selectedPlanningId = null;

function updateCapacity() {
    const select = document.getElementById('event-selector');
    const capacity = select.options[select.selectedIndex].getAttribute('data-capacity');
    selectedPlanningId = select.options[select.selectedIndex].getAttribute('data-planning-id');
    document.getElementById('event-capacity').innerText = capacity;
    document.getElementById('event-capacity-container').style.display = 'block';
        }