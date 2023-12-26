<?php
/*
 * Copyright (c) 2023. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
 * Morbi non lorem porttitor neque feugiat blandit. Ut vitae ipsum eget quam lacinia accumsan.
 * Etiam sed turpis ac ipsum condimentum fringilla. Maecenas magna.
 * Proin dapibus sapien vel ante. Aliquam erat volutpat. Pellentesque sagittis ligula eget metus.
 * Vestibulum commodo. Ut rhoncus gravida arcu.
 */

declare(strict_types=1);

namespace App\Services;

class ProductService
{
    public function syncProductWithMoysklad($productId, $sku)
    {
        // Logic to sync product with Moysklad
        // This replaces the legacy code that checks if the product exists in Moysklad
    }

    public function isProductComponent($productId)
    {
        // Logic to check if the product is a component
    }
}