<!-- <nav class="navbar navbar-expanded-lg" style="background-color: #233754;"> -->
<!--     <img class="nav-item navbar-brand" style="height: 50px;" src="{{ asset('assets/images/logo.svg') }}" alt="Logo"> -->
<!---->
<!--     <div> -->
<!--         <a class="text-secondary text-decoration-none" href="/payment-method">Payment Methods</a> -->
<!--         <a class="text-secondary text-decoration-none ps-3 ps-md-4 ps-lg-5" href="/employee">Employees</a> -->
<!--         <a class="text-secondary text-decoration-none ps-3 ps-md-4 ps-lg-5" href="/discount">Discounts</a> -->
<!--         <a class="text-secondary text-decoration-none ps-3 ps-md-4 ps-lg-5" href="/product">Products</a> -->
<!--         <a class="text-secondary text-decoration-none px-3 px-md-4 px-lg-5" href="/logout">Logout</a> -->
<!--     </div> -->
<!-- </nav> -->

<ul class="navbar navbar-expand-lg navbar-light" style="background-color: #233754;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img class="nav-item navbar-brand" src="{{ asset('assets/images/logo.svg') }}" style="height: 50px" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="/employee" class="nav-link active text-secondary">Employees</a>
                </li>
                <li class="nav-item">
                    <a href="/discount" class="nav-link active text-secondary">Discounts</a>
                </li>
                <li class="nav-item">
                    <a href="/product" class="nav-link active text-secondary">Products</a>
                </li>
                <li class="nav-item">
                    <a href="/password-change/{{ auth()->user()->user_id }}" class="nav-link active text-secondary">Change Password</a>
                </li>
                <li class="nav-item">
                    <a href="/logout" class="nav-link active text-secondary">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</ul>
