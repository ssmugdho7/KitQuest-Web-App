@extends('layout.user.app')
@section('content')
    @include('component.user.MenuBar')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link " id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="order-tab" data-bs-toggle="tab" data-bs-target="#order-tab-pane" type="button" role="tab" aria-controls="order-tab-pane" aria-selected="false">Orders</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane  " id="profile-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        @include('component.user.profile')
                        <button onclick="ProfileCreate()" class="btn btn-danger my-3 d-block mx-auto">Save Changes</button>
                    </div>

                    <div class="tab-pane show active" id="order-tab-pane" role="tabpanel" aria-labelledby="order-tab" tabindex="0">
                        @include('component.user.orders')
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('component.user.Footer')
    <script>


async function ProfileCreate(){

    let name = document.getElementById('name').value;
    let district = document.getElementById('district').value;
    let addressDetails = document.getElementById('addressDetails').value;
    let mobile = document.getElementById('mobile').value;

    let res = await axios.post("/CreateProfile",{name:name,district:district,addressDetails:addressDetails,mobile:mobile});
    if(res.status===200){
        alert('Profile Updated'); 
        window.location.href="/user/profilePage";
    }
    else{
        alert(res.data['message']);
}

}
// 'name','district', 'addressDetails','mobile',











        (async () => {
            await OrderListRequest();
            await ProfileDetails();
            // $(".preloader").delay(90).fadeOut(100).addClass('loaded');
        })()
    </script>


@endsection

