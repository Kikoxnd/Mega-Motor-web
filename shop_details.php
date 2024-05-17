<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:index.php');
}
$product_id = $_GET['id'];


if (isset($_POST['add_to_cart'])) {

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_size = $_POST['product_size'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];
 
    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');
    $fetch_quantcart = mysqli_fetch_assoc($check_cart_numbers);
    $compare_quant = mysqli_query($conn, "SELECT * FROM products WHERE name='$product_name'");
    $fetch_quantitem = mysqli_fetch_assoc($compare_quant);
 
    if (mysqli_num_rows($check_cart_numbers) > 0) {
       $message[] = 'already added to cart!';
    } else {
       // if quantity item = 0 and less than 0 and quantity required more than quantity available
       if ($fetch_quantitem['quant'] == 0 || $fetch_quantitem['quant'] < 0 || $product_quantity > $fetch_quantitem['quant']) {
          $message[] = 'Product out of order or exceed the quantity available';
       } else {
          mysqli_query($conn, "INSERT INTO `cart`(user_id, name, pro_size,price, quantity, image) 
                         VALUES('$user_id', '$product_name', $product_size, '$product_price', '$product_quantity', '$product_image')") or die('query failed');
          $message[] = 'product added to cart!';
       }
       // mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
       // $message[] = 'product added to cart!';
    }
 
 }
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shop</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            background: #C1908B;
        }

        .container {
            max-width: 100%;
            margin: auto;
            height: 80vh;
            margin-top: 5px;
            background: white;
            box-shadow: 5px 5px 10px 3px rgba(0, 0, 0, 0.3);
        }

        .left,
        .right {
            width: 50%;
            padding: 30px;
        }

        .flex {
            display: flex;
            justify-content: space-between;
        }

        .flex1 {
            display: flex;
        }

        .main_image {
            width: 100%;
            /* Set the width to 100% */
            height: 0;
            /* Remove the fixed height */
            padding-top: 100%;
            /* Set the padding-top to create a square aspect ratio */
            position: relative;
            overflow: hidden;
            border: 1px solid black;
            border-radius: 12px;
        }

        .main_image .size_image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        .main_image img {
            width: 100%;
            /* Make the image fill the available space */
            height: 100%;
            /* Make the image fill the available space */
            object-fit: cover;
            /* Scale and crop the image to fit */
        }

        .option img {
            width: 75px;
            height: 75px;
            margin: 10px;
            /* padding: 10px; */
            border-radius: 2px;
            border: 0.7px solid black;
        }

        .right {
            padding: 50px 100px 50px 50px;
        }

        h3 {
            color: #af827d;
            margin: 20px 0 20px 0;
            font-size: 25px;
        }

        h5,
        p,
        small {
            color: #837D7C;
        }

        h4 {
            color: red;
        }

        p {
            margin: 20px 0 50px 0;
            line-height: 25px;
        }

        h5 {
            font-size: 15px;
        }

        label,
        .add span,
        .color span {
            width: 25px;
            height: 25px;
            background: #000;
            border-radius: 50%;
            margin: 20px 10px 20px 0;
        }

        .color span:nth-child(2) {
            background: #EDEDED;
        }

        .color span:nth-child(3) {
            background: #D5D6D8;
        }

        .color span:nth-child(4) {
            background: #EFE0DE;
        }

        .color span:nth-child(5) {
            background: #AB8ED1;
        }

        .color span:nth-child(6) {
            background: #F04D44;
        }

        .add label,
        .add span {
            background: none;
            border: 1px solid #C1908B;
            color: #C1908B;
            text-align: center;
            line-height: 25px;
        }

        .add label {
            padding: 10px 30px 0 20px;
            border-radius: 50px;
            line-height: 0;
        }

        /* button {
            width: 100%;
            padding: 10px;
            border: none;
            outline: none;
            background: #C1908B;
            color: white;
            margin-top: 20%;
            border-radius: 30px;
        } */

        @media only screen and (max-width:768px) {
            .container {
                max-width: 90%;
                margin: auto;
                height: auto;
            }

            .left,
            .right {
                width: 100%;
            }

            .container {
                flex-direction: column;
            }
        }

        @media only screen and (max-width:511px) {
            .container {
                max-width: 100%;
                height: auto;
                padding: 10px;
            }

            .left,
            .right {
                padding: 0;
            }

            img {
                width: 100%;
                height: 100%;
            }

            .option {
                display: flex;
                flex-wrap: wrap;
            }
        }
    </style>
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="css/popup.css"> -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <!-- boot view popup -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>



</head>

<body>
    <?php include 'header.php'; ?>

    <!-- original details fetch data -->
    <?php $get_idproduct = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$product_id' ");
    $fetch_products = mysqli_fetch_assoc($get_idproduct);  ?>


<section>
    <button class="btn btn-primary btn-lg" onclick="history.back()">Go Back</button>
    <div class="container flex">
        
        <div class="left">
                <div class="main_image">
                    <div class="size_image">
                    <!-- <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>"> -->

                        <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" class="slide">
                    </div>
                </div>
                <div class="option flex1">
                    <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" onclick="img('uploaded_img/<?php echo $fetch_products['image']; ?>')">
                </div>
            </div>
            <div class="right">
                <h3>
                    <?php echo $fetch_products['name']; ?>
                </h3>
                <h4> <small>RM </small>
                    <?php echo $fetch_products['price']; ?>
                </h4>
                <p>
                    <?php echo $fetch_products['description'] ?>
                </p>
                <h5>Size:
                    <?php echo $fetch_products['size'] ?>
                    </php>
                </h5>
                <h5>Stock:
                    <?php echo $fetch_products['quant'] ?>
                    </php>
                </h5>

                </br>
                <h5>Quantity</h5>
            </br>
            <!-- <button>Add to cart</button> -->
            <form action="" method="post">
                    <div class="add flex1">
                        <input type="number" min="1" name="product_quantity" placeholder="Enter Quantity" value="1"
                            class="form-control form-control-lg">
        
                    </div>
                    <!-- <input type="hidden" min="1" name="product_quantity" value="1" class="form-control form-control-lg"> -->
                    <input type="hidden" name="product_name" value="<?php echo $fetch_products['id']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                    <input type="hidden" name="product_size" value="<?php echo $fetch_products['Size']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                    <input type="submit" value="Add to cart" class="btn btn-outline-primary btn-lg" name="add_to_cart">
                </form>

            </div>
        </div>
    </section>
    <script>
        function img(anything) {
            document.querySelector('.slide').src = anything;
        }

        function change(change) {
            const line = document.querySelector('.home');
            line.style.background = change;
        }
    </script>
    <!-- Timer and stop the timer based on the real time  -->
    <!-- <p id="demo"></p>

    <button onclick="myStop()">Stop the time</button>
    <script>
        const myInterval = setInterval(myTimer, 1000);

        function myTimer() {
            const date = new Date();
            document.getElementById("demo").innerHTML = date.toLocaleTimeString();
        }

        function myStop() {
            clearInterval(myInterval);
        }
    </script> -->

    <?php include 'footer.php' ?>
</body>

</html>