<!-- <nav class="navbar navbar-expanded-lg" style="background-color: #233754;"> -->
<!--     <img class="nav-item navbar-brand" style="height: 50px;" src="{{ asset('assets/images/logo.svg') }}" alt="Logo"> -->
<!---->
<!--     <div> -->
<!--         <a class="text-secondary text-decoration-none" href="/product">Products</a> -->
<!--         <a class="text-secondary text-decoration-none px-3 px-md-4 px-lg-5" href="/logout">Logout</a> -->
<!--     </div> -->
<!-- </nav> -->

<ul class="navbar navbar-expand-lg custom-toggler" style="background-color: #2f2f2f;">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img class="nav-item navbar-brand" src="{{ asset('assets/images/logo.jpg') }}" style="height: 50px" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="/" class="nav-link active text-secondary">Home</a>
                </li>
                <li class="nav-item">
                    <a href="/summary" class="nav-link active text-secondary">Summary</a>
                </li>
                <li class="nav-item">
                    <a href="/retail" class="nav-link active text-secondary">Retail Price</a>
                </li>
                <li class="nav-item">
                    <a href="/wholesale" class="nav-link active text-secondary">Wholesale Price</a>
                </li>
                <li class="nav-item">
                    <a href="/product" class="nav-link active text-secondary">Product List</a>
                </li>
                <li class="nav-item">
                    <a href="/history" class="nav-link active text-secondary">History</a>
                </li>
                <!-- <li class="nav-item">
                    <a href="/password-change/{{ auth()->user()->user_id }}" class="nav-link active text-secondary">Change Password</a>
                </li> -->
                <li class="nav-item">
                    <a href="/logout" class="nav-link active text-secondary">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</ul>