<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
                </div>
                <div class="modal-body">
                    <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label">Category</label>
                                <select type="text" class="form-control form-select" id="productCategory">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label mt-2">Name</label>
                                <input type="text" class="form-control" id="productName">

                                <label class="form-label mt-2">Price</label>
                                <input type="text" class="form-control" id="productPrice">

                                <label class="form-label mt-2">Unit</label>
                                <input type="text" class="form-control" id="productUnit">
                                
                                <label class="form-label mt-2">Discounted Price(If there is discount)</label>
                                <input type="text" class="form-control" id="discount_price">
                                
                                <label class="form-label mt-2"> Stock</label>
                                <input type="text" class="form-control" id="stock">
                                
                                <label class="form-label mt-2">Rating(Star)%</label>
                                <input type="text" class="form-control" id="star">
                              
                                <label class="form-label">Remark</label>
                                <select type="text" class="form-control form-select" id="remark">
                                    <option value="">Select Category</option>
                                    <option value="New">New</option>
                                    <option value="Trending">Trending </option>
                                    <option value="Featured">Featured</option>
                                    <option value="Best Seller">Best Seller</option>
                                </select>

                                <label> Color</label>
                                <input type="text" class="form-control" id="color">
                                
                                <label for="size"> Size</label>
                                <input type="text" class="form-control" id="size">

                                <label class="form-label mt-2">Description</label>
                                <input type="text" class="form-control" id="des"></input>
                                
                                
                            

                                <br/>
                                <img class="w-15" id="newImg" src="{{asset('images/default.jpg')}}"/>
                                <br/>

                                <label class="form-label">Image</label>
                                <input oninput="newImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImg">

                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button id="modal-close" class="btn bg-gradient-primary mx-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                    <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
                </div>
            </div>
    </div>
</div>


<script>



    FillCategoryDropDown();

    async function FillCategoryDropDown(){
        let res = await axios.get("/list-category")
        res.data.forEach(function (item,i) {
            let option=`<option value="${item['id']}">${item['name']}</option>`
            $("#productCategory").append(option);
        })
    }


    async function Save() {

        let productCategory=document.getElementById('productCategory').value;
        let productName = document.getElementById('productName').value;
        let productPrice = document.getElementById('productPrice').value;
        let productUnit = document.getElementById('productUnit').value;
        let productImg = document.getElementById('productImg').files[0];

        if (productCategory.length === 0) {
            errorToast("Product Category Required !")
        }
        else if(productName.length===0){
            errorToast("Product Name Required !")
        }
        else if(productPrice.length===0){
            errorToast("Product Price Required !")
        }
        else if(productUnit.length===0){
            errorToast("Product Unit Required !")
        }
        else if(!productImg){
            errorToast("Product Image Required !")
        }

        else {

            document.getElementById('modal-close').click();

            let formData=new FormData();
            formData.append('category_id',productCategory)
            formData.append('name',productName)
            formData.append('price',productPrice)
            formData.append('unit',productUnit)
            formData.append('img_url',productImg)
            formData.append('discount_price',document.getElementById('discount_price').value);
            formData.append('stock',document.getElementById('stock').value);
            formData.append('star',document.getElementById('star').value);
            formData.append('remark',document.getElementById('remark').value);
            formData.append('color',document.getElementById('color').value);
            formData.append('size',document.getElementById('size').value);
            formData.append('des',document.getElementById('des').value);
            

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            }

         //   showLoader();
            let res = await axios.post("/create-product",formData,config)
         //   hideLoader();

            if(res.status===201){
                successToast('Request completed');
                document.getElementById("save-form").reset();
                await getList();
            }
            else{
                errorToast("Request fail !")
            }
        }
    }
</script>
