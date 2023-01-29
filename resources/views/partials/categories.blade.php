<?php use App\Models\Category;?>
@each('partials.category', Category::all(), 'category')
