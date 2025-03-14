<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" media="all" />

    <link href='https://fonts.googleapis.com/css?family=Fugaz+One' rel='stylesheet' type='text/css'>
    <link
        href='https://fonts.googleapis.com/css?family=Alegreya+Sans:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,800,800italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    <script type="text/javascript" src="js/jquery.min.js"></script>
</head>

<body>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script src="https://m.servedby-buysellads.com/monetization.js" type="text/javascript"></script>
    <meta name="robots" content="noindex">

    <body>
        <link rel="stylesheet" href="../../../images/demobar_w3_4thDec2019.css">
        <div id="w3lDemoBar" class="w3l-demo-bar">
            <div class="main">
                <div class="content">
                    <script src="{{ asset('js/easyResponsiveTabs.js') }}" type="text/javascript"></script>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#horizontalTab').easyResponsiveTabs({
                                type: 'default',
                                width: 'auto',
                                fit: true
                            });
                        });
                    </script>
                    <div class="sap_tabs">
                        <div id="horizontalTab" style=" width: 100%; margin: 0px;">
                            <div class="pay-tabs">
                                <h2>Pilih Pembayaran</h2>
                                <ul class="resp-tabs-list">
                                    <li class="resp-tab-item" aria-controls="tab_item-0" role="tab">
                                        <span>Virtual Account</span>
                                    </li>
                                    <li class="resp-tab-item" aria-controls="tab_item-1" role="tab">
                                        <span>Retail</span>
                                    </li>
                                    <li class="resp-tab-item" aria-controls="tab_item-3" role="tab">
                                        <span>Qris</span>
                                    </li>
                                    <div class="clear"></div>
                                </ul>
                            </div>
                            <!-- va -->
                            <div class="resp-tabs-container">
                                <div class="tab-1 resp-tab-content" aria-labelledby="tab_item-0">
                                    <h3>Virtual Account</h3>
                                    <div class="va-options">
                                        <div class="va-option">
                                            <a href="{{ url('/payment/navigate/' . 'bni' . '/' . $id) }}">
                                                <img src="{{ asset('images/bni.png') }}" alt="BNI">
                                            </a>
                                            <p>Bank BNI</p>
                                        </div>

                                        <div class="va-option">
                                            <a href="{{ url('/payment/navigate/' . 'bsi' . '/' . $id) }}">
                                                <img src="{{ asset('images/bsi.png') }}" alt="BSI">
                                            </a>
                                            <p>Bank BSI</p>
                                        </div>

                                        <div class="va-option">
                                            <a href="{{ url('/payment/navigate/' . 'bri' . '/' . $id) }}">
                                                <img src="{{ asset('images/bri.png') }}" alt="BRI">
                                            </a>
                                            <p>Bank BRI</p>
                                        </div>

                                        <div class="va-option">
                                            <a href="{{ url('/payment/navigate/' . 'mandiri' . '/' . $id) }}">
                                                <img src="{{ asset('images/mandiri.png') }}" alt="Mandiri">
                                            </a>
                                            <p>Bank Mandiri</p>
                                        </div>
                                    </div>



                                </div>
                                <!-- retail -->
                                <div class="tab-1 resp-tab-content" aria-labelledby="tab_item-1">

                                    <h3>Retail</h3>

                                    <div class="va-options">
                                        <div class="va-option">
                                            <a href="{{ url('/payment/navigate/' . 'alfamart' . '/' . $id) }}">
                                                <img src="{{ asset('images/alfamart.png') }}" alt="BNI">
                                            </a>
                                            <p>Alfamart</p>
                                        </div>

                                        <div class="va-option">
                                            <a href="{{ url('/payment/navigate/' . 'indomaret' . '/' . $id) }}">
                                                <img src="{{ asset('images/indomart.png') }}" alt="BSI">
                                            </a>
                                            <p>Indomaret</p>
                                        </div>


                                    </div>

                                </div>
                                <!-- qris -->
                                <div class="tab-1 resp-tab-content" aria-labelledby="tab_item-2">
                                    <h3>QRIS</h3>
                                    <div class="login-tab">
                                        <div class="user-login">
                                            <form>
                                                <div class="qris-option">
                                                    <a href="{{ url('/payment/navigate/' . 'qris' . '/' . $id) }}">
                                                        <img src="{{ asset('images/qris.png') }}" width="30%"
                                                            height="30%" alt="Qris">
                                                    </a>
                                                </div>
                                                <div class="clear"></div>

                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</body>

</html>
