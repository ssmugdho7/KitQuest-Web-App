<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Invoices</h4>
                    </div>
                </div>
                <hr class="bg-dark "/>
                <table class="table" id="invoiceTable">
                    <thead>
                        <tr class="bg-light">
                            <th>ID</th>
                            <th>VAT</th>
                            <th>Total</th>
                            <th>Payable</th>
                            <th>Delivery Status</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="invoiceTableList">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>


displayInvoice();

async function displayInvoice() {
    let res = await axios.get("/invoice-display");

    let invoiceTableList = $("#invoiceTableList");
    let invoiceTable = $("#invoiceTable");

    invoiceTable.DataTable().destroy();
    invoiceTableList.empty();

    res.data.forEach(function (item, index) {
        let row = `
            <tr>
                <td>${item['id']}</td>
                <td>${item['vat']}</td>
                <td>${item['total']}</td>
                <td>${item['payable']}</td>
                <td>
                    <select class="form-select delivery-status" data-id="${item['id']}">
                        <option value="pending" ${item['delivery_status'] === 'pending' ? 'selected' : ''}>Pending</option>
                        <option value="completed" ${item['delivery_status'] === 'completed' ? 'selected' : ''}>Completed</option>
                        <option value="cancelled" ${item['delivery_status'] === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                    </select>
                </td>
                <td>
                    <select class="form-select payment-status" data-id="${item['id']}">
                        <option value="pending" ${item['payment_status'] === 'pending' ? 'selected' : ''}>Pending</option>
                        <option value="completed" ${item['payment_status'] === 'completed' ? 'selected' : ''}>Completed</option>
                        <option value="cancelled" ${item['payment_status'] === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                    </select>
                </td>
                <td>
                    <button data-id="${item['id']}" class="btn updateBtn btn-sm btn-outline-success">Update</button>
                </td>
            </tr>
        `;
        invoiceTableList.append(row);
    });

    $('.updateBtn').on('click', async function () {
        let id = $(this).data('id');
        let deliveryStatus = $(`.delivery-status[data-id="${id}"]`).val();
        let paymentStatus = $(`.payment-status[data-id="${id}"]`).val();

        await updateInvoiceStatus(id, deliveryStatus, paymentStatus);
    });

    new DataTable('#invoiceTable', {
        order: [[0, 'desc']],
        lengthMenu: [5, 10, 15, 20, 30],
    });
}

async function updateInvoiceStatus(id, deliveryStatus, paymentStatus) {
    try {
        let res = await axios.post("/invoice-update", {
            id: id,
            delivery_status: deliveryStatus,
            payment_status: paymentStatus,
        });

        if (res.status === 200) {
            successToast("Invoice updated successfully!");
            displayInvoice(); // Refresh the table
        } else {
            errorToast("Failed to update the invoice.");
        }
    } catch (error) {
        errorToast("An error occurred while updating the invoice.");
    }
}



</script>

