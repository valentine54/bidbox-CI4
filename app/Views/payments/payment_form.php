<!-- app/Views/payments/payment_form.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Make Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        /* Include the provided CSS here */
        /* Add your custom styles here */
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let tColorA = document.getElementById('tColorA'),
                tColorB = document.getElementById('tColorB'),
                tColorC = document.getElementById('tColorC'),
                iconA = document.querySelector('.fa-credit-card'),
                iconB = document.querySelector('.fa-building-columns'),
                iconC = document.querySelector('.fa-wallet'),
                cDetails = document.querySelector('.card-details');

            function doFun() {
                tColorA.style.color = "greenyellow";
                tColorB.style.color = "#444";
                tColorC.style.color = "#444";
                iconA.style.color = "greenyellow";
                iconB.style.color = "#aaa";
                iconC.style.color = "#aaa";
                cDetails.style.display = "block";
            }

            function doFunA() {
                tColorA.style.color = "#444";
                tColorB.style.color = "greenyellow";
                tColorC.style.color = "#444";
                iconA.style.color = "#aaa";
                iconB.style.color = "greenyellow";
                iconC.style.color = "#aaa";
                cDetails.style.display = "none";
            }

            function doFunB() {
                tColorA.style.color = "#444";
                tColorB.style.color = "#444";
                tColorC.style.color = "greenyellow";
                iconA.style.color = "#aaa";
                iconB.style.color = "#aaa";
                iconC.style.color = "greenyellow";
                cDetails.style.display = "none";
            }

            tColorA.addEventListener('click', doFun);
            tColorB.addEventListener('click', doFunA);
            tColorC.addEventListener('click', doFunB);
        });
    </script>
</head>
<body>
    <div class="container">
        <div class="left">
            <p>Payment methods </p>
            <hr style="border:1px solid #ccc; margin:0 15px;">
            <div class="methods">
                <div onclick="doFun()" id="tColorA" style="color: greenyellow;">
                    <i class="fa-solid fa-credit-card" style="color: greenyellow;"></i>Payment by card
                </div>
                <div onclick="doFunA()" id="tColorB">
                    <i class="fa-solid fa-building-columns"></i>Internet banks
                </div>
                <div onclick="doFunB()" id="tColorC">
                    <i class="fa-solid fa-wallet"></i>Apple Google Pay
                </div>
            </div>
            <hr style="border:1px solid #ccc; margin:0 15px;">
        </div>
        <div class="center">
            <a href="https://www.shift4shop.com/credit-card-logos.html"><img alt="Credit Card Logos" title="Credit Card Logos" src="https://www.shift4shop.com/images/credit-card-logos/cc-lg-4.png" width="250" height="auto"></a>
            <hr style="border:1px solid #ccc; margin:0 15px;">
            <div class="card-details">
                <form>
                    <p>Card number</p>
                    <div class="c-number" id="c-number">
                        <input id="number" class="cc-number" placeholder="Card number" maxlength="19" required>
                        <i class="fa-solid fa-credit-card" style="margin: 0;"></i>
                    </div>
                    <div class="c-details">
                        <div>
                            <p>Expiry date</p>
                            <input id="e-date" class="cc-exp" placeholder="MM/YY" required maxlength="5">
                        </div>
                        <div>
                            <p>CVV</p>
                            <div class="cvv-box" id="cvv-box">
                                <input id="cvv" class="cc-cvv" placeholder="CVV" required maxlength="3">
                                <i class="fa-solid fa-circle-question" title="3 digits on the back of the card" style="cursor: pointer;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="email">
                        <p>Email</p>
                        <input type="email" placeholder="example@gmail.com" id="email" required>
                    </div>
                    <button type="submit">PAY NOW</button>
                </form>
            </div>
        </div>
        <div class="right">
            <p>Order information</p>
            <hr style="border:1px solid #ccc; margin:0 15px;">
            <div class="details">
                <div style="font-weight:bold; padding:3px 0;">Order description</div>
                <div style="padding: 3px 0;">Test payment</div>
            </div>
            <hr style="border:1px solid #ccc; margin:0 15px;">
            <a href="https://www.shift4shop.com/credit-card-logos.html"><img alt="Credit Card Logos" title="Credit Card Logos" src="https://www.shift4shop.com/images/credit-card-logos/cc-lg-4.png" width="100" height="auto"></a>
        </div>
    </div>
</body>
</html>
