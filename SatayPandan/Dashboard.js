document.querySelectorAll('.stat-box').forEach(function(box) {
    box.addEventListener('mouseover', function() {
        this.style.transform = 'scale(1.05)';
    });

    box.addEventListener('mouseout', function() {
        this.style.transform = 'scale(1)';
    });
});

document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.complete-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var orderId = this.dataset.id;
            completeOrder(orderId);
        });
    });
});

function completeOrder(orderId) {
    fetch('complete_order.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            orderId: orderId
        })
    })
    .then(response => {
        if (response.ok) {
            this.closest('tr').remove();             
            fetchCompletedOrders(); 
        }
    })
    .catch(error => console.error('Error:', error));
}

function fetchCompletedOrders() {
    fetch('fetch_completed_orders.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById('completedOrdersTable').innerHTML = data;
    })
    .catch(error => console.error('Error:', error));
}

document.querySelectorAll('.save-btn').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var orderId = this.dataset.id;
        saveOrderStatus(orderId, 'completed');
    });
});

function saveOrderStatus(orderId, newStatus) {
    fetch('save_order_status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            orderId: orderId,
            newStatus: newStatus
        })
    })
    .then(response => {
        if (response.ok) {
           
            alert('Your pending order has been completed.');
            
            location.reload();
        } else {
            alert('Failed to complete the pending order.');
        }
    })
    .catch(error => console.error('Error:', error));
}

function fetchPendingOrders() {
    fetch('fetch_pending_orders.php')
    .then(response => response.text())
    .then(data => {
        document.getElementById('pendingOrdersTable').innerHTML = data;
    })
    .catch(error => console.error('Error:', error));
}
