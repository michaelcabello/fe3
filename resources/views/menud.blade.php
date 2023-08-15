<div class="main-menu">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="menu-list">
                    <nav>
                        <ul class="list-inline">
                            <li class="lists-menus">
                                <a href="index.html">Home</a>
                                <ul class="list-menu">
                                    <li><a href="index.html">Home One</a></li>
                                    <li><a href="index2.html">Home two</a></li>
                                    <li><a href="index3.html">Home three</a></li>
                                    <li><a href="index4.html">Home four</a></li>
                                    <li><a href="index5.html">Home five</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript:void(0)">PRODUCTOS</a>

                                <div class="megamenu">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd-0">
                                                @foreach ($categories as $category)
                                                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                        <div class="links">
                                                            <h4>{{ $category->name }}</h4>
                                                            <ul>
                                                                @foreach ($category->subcategories as $subcategory)
                                                                    <li><a
                                                                            href="{{ route('product.listd.ecommerce', $subcategory->slug) }}">{{ $subcategory->name }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a href="#">WOMENS</a>
                                <div class="megamenu">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pd-0">
                                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                    <div class="links">
                                                        <h4>Shop</h4>
                                                        <ul>
                                                            <li><a href="shop-recommend.html">product</a></li>
                                                            <li><a href="shop-recommend.html">Women</a></li>
                                                            <li><a href="shop-recommend.html">men</a></li>
                                                            <li><a href="shop-recommend.html">Teens</a></li>
                                                            <li><a href="shop-recommend.html">Kids</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                    <div class="links">
                                                        <h4>men</h4>
                                                        <ul>
                                                            <li><a href="shop-recommend.html">Accessories</a>
                                                            </li>
                                                            <li><a href="shop-recommend.html">Women</a></li>
                                                            <li><a href="shop-recommend.html">men</a></li>
                                                            <li><a href="shop-recommend.html">Teens</a></li>
                                                            <li><a href="shop-recommend.html">Kids</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                    <div class="links">
                                                        <h4>men</h4>
                                                        <ul>
                                                            <li><a href="shop-recommend.html">Accessories</a>
                                                            </li>
                                                            <li><a href="shop-recommend.html">Women</a></li>
                                                            <li><a href="shop-recommend.html">men</a></li>
                                                            <li><a href="shop-recommend.html">Teens</a></li>
                                                            <li><a href="shop-recommend.html">Kids</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                                    <div class="links">
                                                        <div class="menu-slider">
                                                            <figure><img src="images/products/2.jpg" alt="" />
                                                            </figure>
                                                            <figure><img src="images/products/3.jpg" alt="" />
                                                            </figure>
                                                            <figure><img src="images/products/4.jpg" alt="" />
                                                            </figure>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="lists-menus">
                                <a href="javascript:void(0)">pages</a>
                                <ul class="list-menu">
                                    <li><a href="about.html">about</a></li>
                                    <li><a href="blog.html">blog</a></li>
                                    <li><a href="blog-single.html">blog single</a></li>
                                    <li><a href="shop-filter.html">shop filter</a></li>
                                    <li><a href="shop-recommend.html">shop recommend</a></li>
                                    <li><a href="shop-single.html">shop-single</a></li>
                                    <li><a href="checkout.html">checkout</a></li>
                                    <li><a href="wishlist.html">wishlist</a></li>
                                    <li><a href="compare.html">compare</a></li>
                                    <li><a href="login.html">Login Register</a></li>
                                </ul>
                            </li>
                            <li><a href="shop.html">SHOP</a></li>
                            <li><a href="contact.html">CONTACT</a></li>
                        </ul>
                    </nav>
                </div>
                <!-- Mobile Menu  Start -->
                <div class="mobilemenu1">
                    <div class="mobile-menu visible-sm visible-xs">
                        <nav>
                            <ul>
                                <li><a href="javascript:void(0)">Home</a>
                                    <ul>
                                        <li><a href="index.html">Home One</a></li>
                                        <li><a href="index2.html">Home two</a></li>
                                        <li><a href="index3.html">Home three</a></li>
                                        <li><a href="index4.html">Home four</a></li>
                                        <li><a href="index5.html">Home five</a></li>
                                    </ul>
                                </li>
                                <li><a href="shop-recommend.html">mens</a></li>
                                <li><a href="shop-recommend.html">WOMENS</a></li>
                                <li><a href="shop.html">SHOP</a></li>
                                <li>
                                    <a href="javascript:void(0)">pages</a>
                                    <ul class="list-menu">
                                        <li><a href="about.html">about</a></li>
                                        <li><a href="blog.html">blog</a></li>
                                        <li><a href="blog-single.html">blog single</a></li>
                                        <li><a href="shop-filter.html">shop filter</a></li>
                                        <li><a href="shop-recommend.html">shop recommend</a></li>
                                        <li><a href="shop-single.html">shop-single</a></li>
                                        <li><a href="checkout.html">checkout</a></li>
                                        <li><a href="wishlist.html">wishlist</a></li>
                                        <li><a href="compare.html">compare</a></li>
                                        <li><a href="login.html">Login Register</a></li>
                                    </ul>
                                </li>
                                <li><a href="contact.html">CONTACT US</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Mobile Menu  End -->
            </div>
        </div>
    </div>
    <div class="cat-ser">
        <div class="catagery-list">
            <span><i class="fa fa-folder-open-o"></i></span>
            <select>
                <option>Category</option>
                <option>Electronic</option>
                <option>Associroies</option>
                <option>Electronic</option>
            </select>
        </div>
        <div class="search-box">
            <form>
                <input type="search" placeholder="Search your item here...">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
</div>
