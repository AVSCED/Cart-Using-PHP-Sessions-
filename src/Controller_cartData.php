<?php
session_start();

//To add a product to the cart
if (isset($_POST['addToCart'])) {
    if (!isset($_SESSION['data'])) {
        $_SESSION['data'] = [];
    }
    $product_ID = $_POST['pid'];
    $l = count($_SESSION['data']);
    $i = 0;
    $flag = 0;
    if ($l != 0) // To check if the added product already exists in the cart
    {
        foreach ($_SESSION['data'] as $key => $value) {
            if ($value['id'] == $product_ID) {
                $flag = 1;
            }
        }
        if ($flag == 1) // To increment the quantity of a product already existing in the cart when added again 
        {
            foreach ($_SESSION['data'] as $key => $value) {

                if ($value['id'] == $product_ID) {
                    $_SESSION['data'][$i]['quantity'] = $_SESSION['data'][$i]['quantity'] + 1;
                }
                $i = $i + 1;
            }
        } else // To add product to the cart that is not present already in the cart
        {
            $product_Quantitiy = 1;
            $cart_Data = array("id" => $product_ID, "quantity" => $product_Quantitiy);
            array_push($_SESSION['data'], $cart_Data);
        }
    } else  // To add a product to a blank cart 
    {
        $product_Quantitiy = 1;
        $cart_Data = array("id" => $product_ID, "quantity" => $product_Quantitiy);
        array_push($_SESSION['data'], $cart_Data);
    }
    header("location:View_products.php");
}
// To reduce the quantity of a product in the cart
if (isset($_POST['reduceQuant'])) {
    $i = 0;
    $product_ID = $_POST['pid'];
    foreach ($_SESSION['data'] as $key => $value) {
        if ($value['id'] == $product_ID) {
            if ($_SESSION['data'][$i]['quantity'] == 1) {
                array_splice($_SESSION['data'], $i, 1);
            } else {
                $_SESSION['data'][$i]['quantity'] = $_SESSION['data'][$i]['quantity'] - 1;
            }
        }
        $i = $i + 1;
    }
    header("location:View_products.php");
}
// To increment the quantity of a product in the cart
if (isset($_POST['addQuant'])) {
    $i = 0;
    $product_ID = $_POST['pid'];
    foreach ($_SESSION['data'] as $key => $value) {
        if ($value['id'] == $product_ID) {
            $_SESSION['data'][$i]['quantity'] = $_SESSION['data'][$i]['quantity'] + 1;
        }
        $i = $i + 1;
    }
    header("location:View_products.php");
}
// To Delete a specific row from the cart
if (isset($_POST['delRow'])) {
    $product_ID = $_POST['pid'];
    $i = 0;
    foreach ($_SESSION['data'] as $key => $value) {
        if ($value['id'] == $product_ID) {
            array_splice($_SESSION['data'], $i, 1);
        }
        $i = $i + 1;
    }
    header("location:View_products.php");
}
//To Empty the entire cart
if (isset($_POST['deleteCart'])) {
    $_SESSION['data'] = [];
    header("location:View_products.php");
}
