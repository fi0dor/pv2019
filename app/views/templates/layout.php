<!DOCTYPE html>
<html lang="en">
    <head>
        <?php if (!empty(APP_DIRECTORY)): ?>
            <base href="<?= '/' . APP_DIRECTORY ?>">
        <?php endif; ?>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="description" content="<?= META_DESC ?>">
        <meta name="keywords" content="<?= META_KEYWORDS ?>">

        <title><?= $data["title"]; ?></title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        
        <link rel="stylesheet" href="public/css/style.css" type="text/css">
    </head>

    <body>
        <header> 
            <div class="header-box">
                <div class="container"> 
                    <div class="row"> 
                         <div class="demo_site-nav">
                           <nav class="navbar navbar-expand-lg navbar-dark bg-primary demo_navbar">
                                <a class="navbar-brand demo_navbar-brand" href="<?= URL_ROOT; ?>"><?= SITE_NAME; ?></a> 
                                
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div class="collapse navbar-collapse" id="navbarText">
                                    <ul class="navbar-nav mr-auto demo_navbar-nav">
                                        <li class="nav-item active">
                                            <a class="nav-link" href="<?= URL_ROOT ?>">Home <span class="sr-only">(current)</span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="contact">Contact</a>
                                        </li>
                                    </ul>
                                    
                                    <span class="navbar-text">
                                        <a href="<?= URL_ROOT ?>cart">
                                            <i class="fa fa-shopping-cart" title="Shopping Cart"></i>
                                            <span class="badge badge-light demo_cart-counter"><?= $data["count_carts"] ?></span>
                                            
                                            <i class="fa fa-university"></i>
                                            <span class="badge badge-light demo_wallet-balance-display"><?= $data["user_wallet_balance"] . ' ' . EURO ?></span>
                                        </a>
                                    </span>
                                </div>
                            </nav> 
                        </div>  
                    </div> 
                </div>
            </div>
        </header>

        <section>
            <?= $main_Content; ?>
        </section>
        
        <div class="modal fade" id="demo_modal" tabindex="-1" role="dialog" aria-labelledby="demo_modal-title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Notification</h5>
                        
                        <button class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body"> </div>
                    
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Close</button> 
                    </div>
                </div>
            </div>
        </div> 

        <footer>
            &copy; Copyright <?= date("Y"); ?>
        </footer>

        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
         
        <script src="public/js/home.js"></script>
        <script src="public/js/cart.js"></script>

        <?= $javascript_Content; ?>
    </body>
</html>