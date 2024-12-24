<!-- START SECTION BREADCRUMB -->
<div class="breadcrumb_section bg-light py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="m-0">Cart List</h1>
            </div>
            <div class="col-md-6 text-md-end text-start">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{url("/")}}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">This Page</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION BREADCRUMB -->

<!-- START CART SECTION -->
<div class="mt-5">
    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive shop_cart_table border p-3 shadow-sm rounded">
                    <table class="table align-middle">
                        <thead class="table-light">
                        <tr>
                            <th class="product-thumbnail">Image</th>
                            <th class="product-name">Product</th>
                            <th class="product-quantity text-center">Quantity</th>
                            <th class="product-subtotal text-end">Total</th>
                            <th class="product-remove text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody id="byList">
                            <!-- Dynamic Data Goes Here -->
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6" class="px-0">
                                <div class="row g-0 align-items-center">
                                    <div class="col-lg-4 col-md-6 mb-3 mb-md-0">
                                        <h5 class="m-0">Total: BDT <span id="total" class="text-success fw-bold">0.00</span></h5>
                                    </div>
                                    <div class="col-lg-8 col-md-6 text-start text-md-end">
                                        <button onclick="CheckOut()" class="btn btn-primary px-4 py-2" type="submit">Proceed to Checkout</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

    
async function ProfileDetails() {
    try {
        let res = await axios.get("/ReadProfile");

        if (res.data['data'] !== null) {
            // Update form fields based on the response
            document.getElementById('name').value = res.data['data']['name'] ;
            document.getElementById('district').value = res.data['data']['district'];
            document.getElementById('addressDetails').value = res.data['data']['addressDetails'];
            document.getElementById('mobile').value = res.data['data']['mobile'] ;
        } else {
            console.log("No profile data found.");
        }
    } catch (error) {
        console.error("Error fetching profile details:", error);
    }
}



    async function CartList(){
        let res=await axios.get(`/CartList`);
        $("#byList").empty();

        res.data['data'].forEach((item,i)=>{
             let imgBasePath = "{{ asset('') }}";
            let EachItem=`<tr>
                            <td class="product-thumbnail"><img src="${imgBasePath}${item['product']['img_url']}" alt="product"></td>
                            <td class="product-name" >${item['product']['name']} </td>
                            <td class="product-quantity"> ${item['qty']} </td>
                            <td class="product-subtotal">BDT ${item['price']}</td>
                            <td class="product-remove"><a class="remove" data-id="${item['product_id']}"><i class="ti-close"></i></a></td>
                        </tr>`
            $("#byList").append(EachItem);
        })

        await CartTotal(res.data['data']);

        $(".remove").on('click',function () {
            let id= $(this).data('id');
            RemoveCartList(id);
        })


    }


    async function CartTotal(data){
        let Total=0;
        data.forEach((item,i)=>{
            Total=Total+parseFloat(item['price']);
        })
        $("#total").text(Total);
    }



   async function RemoveCartList(id){
     // $(".preloader").delay(90).fadeIn(100).removeClass('loaded');
        let res=await axios.get("/DeleteCartList/"+id);
     // $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        if(res.status===200) {
            await CartList();
        }
        else{
            alert("Request Fail")
        }
    }


    async function CheckOut(){

            let res=await axios.post("/InvoiceCreate",{
                "name":document.getElementById('name').value,
                "district": document.getElementById('district').value,
                "addressDetails":document.getElementById('addressDetails').value,
                "mobile": document.getElementById('mobile').value
            });


        if(res.status===200){
      
            alert("Thanks for your order");
            setTimeout(function(){ window.location.href="/user/profilePage"; }, 2000);
        }

        else{
            alert("Profile Creation Failed")
        }

    }
    
function checkFormCompletion() {
    const name = document.getElementById('name').value;
    const district = document.getElementById('district').value;
    const addressDetails = document.getElementById('addressDetails').value;
    const mobile = document.getElementById('mobile').value;

    // Enable the checkout button if all fields are filled
    const checkoutBtn = document.getElementById('checkoutBtn');
    if (name && district && addressDetails && mobile) {
        checkoutBtn.disabled = false;  // Enable the button
    } else {
        checkoutBtn.disabled = true;   // Disable the button
    }
}

// Event listeners to trigger the form validation when input is changed
document.getElementById('name').addEventListener('input', checkFormCompletion);
document.getElementById('district').addEventListener('input', checkFormCompletion);
document.getElementById('addressDetails').addEventListener('input', checkFormCompletion);
document.getElementById('mobile').addEventListener('input', checkFormCompletion);

// Initially disable the checkout button
document.getElementById('checkoutBtn').disabled = true;



    


</script>
