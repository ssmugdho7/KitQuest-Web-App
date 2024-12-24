<header class="header_wrap fixed-top header_with_topbar">
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <ul class="contact_detail text-center text-lg-start">
                            <li><i class="ti-mobile"></i><span>+880 1758551245</span></li>
                            <li><i class="ti-email"></i><span>info@kitquest.com</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center text-md-end">
                        <ul class="header_list">
                            <li><a href="/user/policyPage?type=about">About</a></li>
                            
                            @if(Cookie::get('token') !== null)
                            <li><a href="{{url("/user/profilePage")}}"> <i class="linearicons-user"></i> Account</a></li>
                            <li><a class="btn btn-danger btn-sm" href="{{url("/logout")}}"> Logout</a></li>
                            @else
                            <li><a class="btn btn-danger btn-sm" href="{{url("/user/loginPage")}}">Login</a></li>
                            @endif
                            
                            <li><a href="/dashboard">Admin Dashboard</a></li>


                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom_header dark_skin main_menu_uppercase">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="{{url("/")}}">
                    <!-- <img class="logo_dark" src="assets/images/logo_dark.png" alt="logo" />    -->
                    <!-- <img src="{{ asset('assets/images/logo_dark.png') }}" alt="Example Image"> -->
                     <h4>KITQUEST</h4>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-expanded="false">
                    <span class="ion-android-menu"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li><a class="nav-link nav_item" href="{{url("/")}}">Home</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Products</a>
                            <div class="dropdown-menu">
                                <ul id="CategoryItem">

                                </ul>
                            </div>
                        </li>
                        <li><a class="nav-link nav_item" href="{{url("/user/wishListPage")}}"><i class="ti-heart"></i> Wish</a></li>
                        <li><a class="nav-link nav_item" href="{{url("/user/cartPage")}}"><i class="linearicons-cart"></i> Cart </a></li>
                        <li><a href="javascript:void(0);" class="nav-link search_trigger"><i class="linearicons-magnifier"></i> Search</a>
                            <div class="search_wrap">
                                <span class="close-search"><i class="ion-ios-close-empty"></i></span>
                                <form>
                                    <input type="text" placeholder="Search" class="form-control" id="search_input">
                                    <button type="submit" class="search_icon"><i class="ion-ios-search-strong"></i></button>
                                </form>
                            </div><div class="search_overlay"></div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>

<script>
    async function Category(){
        let res=await axios.get("/userCategoryList");
        $("#CategoryItem").empty()
        res.data['data'].forEach((item,i)=>{
            let EachItem= ` <li><a class="dropdown-item nav-link nav_item" href="/user/ProductByCategoryPage?id=${item['id']}">${item['name']}</a></li>`
            $("#CategoryItem").append(EachItem);
        })
    }
</script>
