<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="ion-close"></i>
    </button>

    <div class="sidebar-inner slimscrollleft">
        <div id="sidebar-menu">
            <ul>

                <li>
                    <a href="{{ url('/admin') }}" class="waves-effect">
                        <i class="dripicons-meter"></i>
                        <span> Dashboard </span>
                    </a>
                </li>


                @if (auth()->user()->can('Blog List'))
                    <li>
                        <a href="{{ route('blog.index') }}" class="waves-effect">
                            <i class="dripicons-article"></i>
                            <span> Blogs </span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->can('category-view') || auth()->user()->can('products-view'))
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-archive"></i><span>
                                Catalog </span> <span class="menu-arrow float-right"><i
                                    class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                            @can('category-view')
                                <li><a href="{{ route('category.index') }}"><i class="mdi mdi-view-grid"></i>Categories</a></li>
                            @endcan
                            {{-- <li><a href="{{ route('catex`gorytag.index') }}"><i class="mdi mdi-tag-multiple"></i>Product Tags</a></li> --}}
                            @can('products-view')
                                <li><a href="{{ route('product.index') }}"><i class="mdi mdi-package-variant"></i>Products</a></li>
                            @endcan
                            @can('tax-view')
                                <li><a href="{{ route('attribute.index') }}"><i class="mdi mdi-format-list-bulleted"></i>Attributes</a></li>
                            @endcan
                            @can('tax-view')
                                <li><a href="{{ route('tax.index') }}"><i class="mdi mdi-cash"></i>Tax Settings</a></li>
                            @endcan

                            <li>
                                <a href="{{ route('shippingchargesedit') }}" class="waves-effect">
                                    <i class="dripicons-to-do"></i>
                                    <span> Shipping Settings </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->can('all_orders-view'))
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-cart"></i><span> Orders
                            </span> <span class="menu-arrow float-right"><i
                                    class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('order.index') }}"><i class="mdi mdi-cart"></i>All Orders</a></li>
                            <li><a href="{{ route('filter', 'paid') }}"><i class="mdi mdi-cash-multiple"></i>Paid Orders</a></li>
                            <li><a href="{{ route('filter', 'unpaid') }}"><i class="mdi mdi-cash-usd"></i>Unpaid Orders</a></li>
                            <li><a href="{{ route('progress') }}"><i class="mdi mdi-settings"></i>Processing</a></li>
                            <li><a href="{{ route('deliver') }}"><i class="mdi mdi-truck"></i>Dispatched</a></li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->can('banner-view'))
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-photo"></i><span>
                                Appearance </span> <span class="menu-arrow float-right"><i
                                    class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                            @can('banner-view')
                                <li><a href="{{ route('banner.index') }}"><i class="mdi mdi-image-filter"></i>Home Banners</a></li>
                            @endcan
                            <li><a href="{{ route('product_review.index') }}"><i class="mdi mdi-star-circle"></i>Product Reviews</a></li>
                            <li><a href="{{ route('testimonial.index') }}"><i class="mdi mdi-comment-account"></i>Testimonials</a></li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->can('coupon-view'))
                    <li>
                        <a href="{{ route('coupon.index') }}" class="waves-effect">
                            <i class="dripicons-ticket"></i>
                            <span> Coupons </span>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->can('customer-view') || auth()->user()->can('user-view'))
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-user-group"></i><span>
                                Users </span> <span class="menu-arrow float-right"><i
                                    class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                            @can('user-view')
                                <li><a href="{{ route('user.index') }}"><i class="mdi mdi-account-star"></i>Staff Admin</a></li>
                            @endcan
                            @can('customer-view')
                                <li><a href="{{ route('customer.list') }}"><i class="mdi mdi-account-multiple"></i>Customers</a></li>
                            @endcan

                            <li>
                                <a href="{{ route('contactlist.index') }}" class="waves-effect">
                                    <i class="dripicons-mail"></i>
                                    <span> Inquiries </span>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif

                <li>
                    <a href="{{ route('settings.index') }}" class="waves-effect">
                        <i class="dripicons-gear"></i>
                        <span> General Settings </span>
                    </a>
                </li>

              

                {{-- <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-document"></i><span>
                            CMS Pages </span> <span class="menu-arrow float-right"><i
                                class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        @can('About Us List')
                            <li><a href="{{ route('about.index') }}"><i class="mdi mdi-information-outline"></i>About Us</a></li>
                        @endcan
                        @can('Contact List')
                            <li><a href="{{ route('contact.index') }}"><i class="mdi mdi-contacts"></i>Contact Info</a></li>
                        @endcan
                        @can('FAQs List')
                            <li><a href="{{ route('faqs.index') }}"><i class="mdi mdi-help-circle-outline"></i>FAQs</a></li>
                        @endcan
                    </ul>
                </li> --}}

               

               
            </ul>
        </div>

        {{-- <div class="sidebar-user-card">
            <img src="{{ asset(auth()->user()->profile_image ? 'assets/images/users/' . auth()->user()->profile_image : 'assets/images/user.png') }}"
                class="sidebar-user-avatar" alt="user">
            <div class="sidebar-user-info">
                <span class="sidebar-user-name">{{ auth()->user()->name }}</span>
                <span class="sidebar-user-role">Administrator</span>
            </div>
        </div>
        <div class="clearfix"></div> --}}
    </div>
</div>
