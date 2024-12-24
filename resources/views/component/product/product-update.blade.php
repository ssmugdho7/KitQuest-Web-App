<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category</label>
                                <select class="form-control form-select" id="productCategoryUpdate">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-2">Name</label>
                                <input type="text" class="form-control" id="productNameUpdate">

                                <label class="form-label mt-2">Price</label>
                                <input type="text" class="form-control" id="productPriceUpdate">

                                <label class="form-label mt-2">Unit</label>
                                <input type="text" class="form-control" id="productUnitUpdate">

                                <label class="form-label mt-2">Discounted Price (If there is a discount)</label>
                                <input type="text" class="form-control" id="discountPriceUpdate">

                                <label class="form-label mt-2">Stock</label>
                                <input type="text" class="form-control" id="stockUpdate">

                                <label class="form-label mt-2">Rating (Star)%</label>
                                <input type="text" class="form-control" id="starUpdate">

                                <label class="form-label">Remark</label>
                                <select class="form-control form-select" id="remarkUpdate">
                                    <option value="">Select Remark</option>
                                    <option value="New">New</option>
                                    <option value="Trending">Trending</option>
                                    <option value="Featured">Featured</option>
                                    <option value="Best Seller">Best Seller</option>
                                </select>

                                <label class="form-label mt-2">Color</label>
                                <input type="text" class="form-control" id="colorUpdate">

                                <label class="form-label mt-2">Size</label>
                                <input type="text" class="form-control" id="sizeUpdate">

                                <label class="form-label mt-2">Description</label>
                                <input type="text" class="form-control" id="descriptionUpdate">

                                <br />
                                <img class="w-15" id="oldImg" src="{{ asset('images/default.jpg') }}" />
                                <br />
                                <label class="form-label mt-2">Image</label>
                                <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImgUpdate">

                                <input type="hidden" id="updateID">
                                <input type="hidden" id="filePath">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="update-modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="update()" id="update-btn" class="btn bg-gradient-success">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
  

  async function UpdateFillCategoryDropDown(){
        let res = await axios.get("/list-category")
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#productCategoryUpdate").append(option);
        })
    }


    async function FillUpUpdateForm(id,filePath){

        document.getElementById('updateID').value=id;
        document.getElementById('filePath').value=filePath;
        document.getElementById('oldImg').src=filePath;


        //showLoader();
        await UpdateFillCategoryDropDown();

        let res=await axios.post("/product-by-id",{id:id})
       // hideLoader();

        document.getElementById('productNameUpdate').value=res.data['name'];
        document.getElementById('productPriceUpdate').value=res.data['price'];
        document.getElementById('productUnitUpdate').value=res.data['unit'];
        document.getElementById('productCategoryUpdate').value=res.data['category_id'];
        document.getElementById('discountPriceUpdate').value=res.data['discount_price'];
        document.getElementById('stockUpdate').value=res.data['stock'];
        document.getElementById('starUpdate').value=res.data['star'];
        document.getElementById('remarkUpdate').value=res.data['remark'];
        document.getElementById('colorUpdate').value=res.data['color'];
        document.getElementById('sizeUpdate').value=res.data['size'];
        document.getElementById('descriptionUpdate').value=res.data['des'];

    }



   
   
   
    async function update() {
    let formData = new FormData();

    let file = document.getElementById("productImgUpdate").files[0];
    if (file) {
        formData.append("img", file);
    }
    formData.append("id", document.getElementById("updateID").value);
    formData.append("name", document.getElementById("productNameUpdate").value || "");
    formData.append("price", document.getElementById("productPriceUpdate").value || "");
    formData.append("unit", document.getElementById("productUnitUpdate").value || "");
    formData.append("category_id", document.getElementById("productCategoryUpdate").value || "");
    formData.append("discount_price", document.getElementById("discountPriceUpdate").value || null);
    formData.append("stock", document.getElementById("stockUpdate").value || null);
    formData.append("star", document.getElementById("starUpdate").value || null);
    formData.append("remark", document.getElementById("remarkUpdate").value || null);
    formData.append("color", document.getElementById("colorUpdate").value || null);
    formData.append("size", document.getElementById("sizeUpdate").value || null);
    formData.append("des", document.getElementById("descriptionUpdate").value || null);

    const config = {
        headers: {
            "Content-Type": "multipart/form-data",
        },
    };

    try {
        console.log("Submitting Product Data:", formData);
        let res = await axios.post("/product-update", formData, config);

        if (res.status === 200 && res.data.success) {
            successToast(res.data.message || "Product updated successfully!");
            document.getElementById("update-form").reset();
            await getList(); // Refresh the product list
            document.getElementById("update-modal-close").click(); // Close the modal
        } else {
            errorToast(res.data.message || "Failed to update product.");
        }
    } catch (error) {
        errorToast("An error occurred while updating the product.");
        console.error(error);
    }
}


</script>
