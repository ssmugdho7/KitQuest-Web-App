<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_s4 text-center">
                    <h2>Top Categories</h2>
                </div>
                <p class="text-center leads">Explore our wide range of premium soap-making ingredients, from natural oils and butters to vibrant pigments and essential oils, perfect for creating luxurious, handmade soaps.</p>
            </div>
        </div>
        <div id="TopCategoryItem" class="row align-items-center">


        </div>
    </div>
</div>


<script>

    async function TopCategory(){
        let res=await axios.get("/userCategoryList");
        $("#TopCategoryItem").empty()
        res.data['data'].forEach((item,i)=>{
            let EachItem= `<div class="p-2 col-3">
                <div class="item">
                    <div class="categories_box">
                        <a href="/user/ProductByCategoryPage?id=${item['id']}">
                            <img src="${item['img_url']}" alt="cat_img1"/>
                            <span>${item['name']}</span>
                        </a>
                    </div>
                </div>
            </div>`
            $("#TopCategoryItem").append(EachItem);
        })
    }
</script>

