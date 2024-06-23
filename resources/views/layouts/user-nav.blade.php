<!-- <nav class="navbar navbar-expanded-lg" style="background-color: #233754;"> -->
<!--     <img class="nav-item navbar-brand" style="height: 50px;" src="{{ asset('assets/images/logo.svg') }}" alt="Logo"> -->
<!---->
<!--     <div> -->
<!--         <a class="text-secondary text-decoration-none" href="/">Process Orders</a> -->
<!--         <a class="text-secondary text-decoration-none ps-3 ps-md-4 ps-lg-5" href="/history">History</a> -->
<!--         <a class="text-secondary text-decoration-none px-3 px-md-4 px-lg-5" wire:confirm="Logout?" wire:click="logout">Logout</a> -->
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
                    <a href="/" class="nav-link active text-secondary">Process Orders</a>
                </li>
                <li class="nav-item">
                    <a href="/history" class="nav-link active text-secondary">History</a>
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
