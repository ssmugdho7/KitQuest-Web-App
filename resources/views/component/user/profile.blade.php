<!-- START USER DETAILS FORM -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="text-center mb-4">Please Fill these informations To Proceed</h4>
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label for="district" class="form-label">District</label>
                            <input type="text" class="form-control" id="district" name="district" placeholder="Enter your district" required>
                        </div>
                        <div class="mb-3">
                            <label for="addressDetails" class="form-label">Address Details</label>
                            <textarea class="form-control" id="addressDetails" name="addressDetails" rows="3" placeholder="Enter full address" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Enter your mobile number" required>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END USER DETAILS FORM -->


   




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


</script>
