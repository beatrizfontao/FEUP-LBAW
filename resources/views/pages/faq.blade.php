@extends('layouts.app')

@section('title', 'About Us')

@section('content')

<div class="p-0">
    <div id="userProfile" class="container col-md-7 px-0 px-sm-2 p-lg-5 p-3 shadow-sm h-100">
        <div style="text-align: center; font-size: 2.5rem; grid-row: 1; margin-bottom: 2rem;">
            <h3>Frequently Asked Questions</h3>
        </div>
        <div class="accordion mb-4" id="faq_list">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Q1 - How do I find a product?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne">
                    <div class="accordion-body px-1 px-sm-3">
                        A - You can enter the name of the product in the search bar present at the top of the page. You can also select specific categories and brands by using the options on the top bar.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Q2 - How do I purchase a product?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo">
                    <div class="accordion-body px-1 px-sm-3">
                        A - Once you are in the product's individual page, you add or remove that products from your shopping cart by using the minus and the plus buttons. The quantity will appear between those buttons. Then click on the cart item at the top right corner. Once you can see the products present in your shopping cart you can proceed to checkout.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Q3 - I've made an order. How can I check its status?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree">
                    <div class="accordion-body px-1 px-sm-3">
                        A - You can access you profile by clicking on your username at the top right corner. Then on the hamburger menu choose the option 'My Orders'. You will then see all your order. Click on the one that interests you and check the its status.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Q4 - How can I check my notifications?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour">
                    <div class="accordion-body px-1 px-sm-3">
                        A - You can see your notifications by clicking the bell icon on the top bar. It will then open a dropdown menu where you can check all your notifications.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        Q5 - How can I delete my account?
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive">
                    <div class="accordion-body px-1 px-sm-3">
                        A - If you go to your profile, you will see a red button that says 'Delete account'. By clicking there you will see a pop up confirmation. Choose the option delete account.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection