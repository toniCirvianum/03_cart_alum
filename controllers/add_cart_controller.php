<?php
session_start();
//carreguem funcions de producte
include('../functions/product_functions.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id_product = $_POST['id'];

        //Si no existeix iniciem la varibale de sessio de cart
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        //Busquem el producte al carret
        $product = getProductById($id_product, $_SESSION['cart']);

        if ($product != null) {
            //si el producte esta al carret actualitzem la qty
            foreach ($_SESSION['cart'] as $key => $cartProduct) {
                if ($cartProduct['id'] == $id_product) {
                    $_SESSION['cart'][$key]['qty']++;
                }
            }
        } else {
            //si el producte no és al carret l'afegim
            $product = getProductById($id_product, $_SESSION['products']);
            $product['qty'] = 1;
            array_push($_SESSION['cart'], $product);
            $_SESSION['product_added'] = true;
        }

        // header('Location: ../views/products.php?productInCart=true');
        // exit;

        echo "<pre>";
        print_r($_SESSION['cart']);
        echo "</pre>";
    }
}
