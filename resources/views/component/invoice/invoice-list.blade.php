<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between">
                    <div class="align-items-center col">
                        <h4>Invoices</h4>
                    </div>
                </div>
                <hr class="bg-dark"/>
                <table class="table" id="invoiceTable">
                    <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Total</th>
                            <th>VAT</th>
                            <th>Payable</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="invoiceTableList"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<script>
    // Function to fetch and display invoice data
    async function fetchInvoiceData() {
        try {
            let response = await axios.get('/invoice-select'); // Adjust the route to your API endpoint
            let invoices = response.data;

            let tableList = $("#invoiceTableList");
            let table = $("#invoiceTable");

            // Destroy any existing DataTable instance to prevent conflicts
            table.DataTable().destroy();

            // Clear table body
            tableList.empty();

            // Append rows to the table body
            invoices.forEach(function (item, index) {
                let row = `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${item.name ?? 'N/A'}</td>
                        <td>${item.mobile ?? 'N/A'}</td>
                        <td>${item.total}</td>
                        <td>${item.vat}</td>
                        <td>${item.payable}</td>
                        <td>
                            <button data-id="${item.id}" class="btn btn-sm btn-outline-primary updateStatusBtn">Update Status</button>
                        </td>
                    </tr>
                `;
                tableList.append(row);
            });

            // Reinitialize DataTable
            new DataTable('#invoiceTable', {
                order: [[0, 'asc']],
                lengthMenu: [5, 10, 15, 20],
            });

            // Add event listener for "Update Status" buttons
            $('.updateStatusBtn').on('click', function () {
                let invoiceId = $(this).data('id');
                updateInvoiceStatus(invoiceId);
            });

        } catch (error) {
            console.error("Error fetching invoice data:", error);
            alert("Failed to fetch invoice data!");
        }
    }

    // Function to update the invoice status
    async function updateInvoiceStatus(invoiceId) {
        try {
            let deliveryStatus = prompt("Enter Delivery Status (pending/completed/cancelled):");
            let paymentStatus = prompt("Enter Payment Status (pending/completed/cancelled):");

            if (deliveryStatus && paymentStatus) {
                let response = await axios.post('/invoice-update', {
                    id: invoiceId,
                    delivery_status: deliveryStatus,
                    payment_status: paymentStatus,
                });

                if (response.status === 200) {
                    alert("Invoice status updated successfully!");
                    fetchInvoiceData(); // Refresh the table
                } else {
                    alert("Failed to update invoice status.");
                }
            } else {
                alert("Both statuses are required.");
            }
        } catch (error) {
            console.error("Error updating invoice status:", error);
            alert("An error occurred while updating the invoice status.");
        }
    }

    // Call the function to fetch and display invoice data
    fetchInvoiceData();
</script>
