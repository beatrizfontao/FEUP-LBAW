<?php use App\Models\Brand;?>
@each('partials.brand', Brand::all(), 'brand')
