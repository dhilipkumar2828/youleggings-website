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

                @if (auth()->user()->can('category-view') || auth()->user()->can('products-view'))
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-archive"></i><span>
                                Catalog </span> <span class="menu-arrow float-right"><i
                                    class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                            @can('category-view')
                                <li><a href="{{ route('category.index') }}"><i class="mdi mdi-view-grid"></i>Categories</a></li>
                            @endcan
                            @can('products-view')
                                <li><a href="{{ route('product.index') }}"><i class="mdi mdi-package-variant"></i>Products</a></li>
                            @endcan
                            @can('tax-view')
                                <li><a href="{{ route('attribute.index') }}"><i class="mdi mdi-format-list-bulleted"></i>Attributes</a></li>
                            @endcan
                            @can('tax-view')
                                <li><a href="{{ route('tax.index') }}"><i class="mdi mdi-cash"></i>Tax Settings</a></li>
                            @endcan
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

                @if (auth()->user()->can('inventory-view'))
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-stack"></i><span>
                                Inventory </span> <span class="menu-arrow float-right"><i
                                    class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('product.listproduct') }}"><i class="mdi mdi-clipboard-text"></i>Stock List</a></li>
                            <li><a href="{{ route('product.stockoutproduct') }}"><i class="mdi mdi-package-down"></i>Out of Stock</a></li>
                            <li><a href="{{ route('product.inactiveproduct') }}"><i class="mdi mdi-eye-off"></i>Inactive Items</a></li>
                        </ul>
                    </li>
                @endif

                @if (auth()->user()->can('banner-view') || auth()->user()->can('advertisement-index'))
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-photo"></i><span>
                                Appearance </span> <span class="menu-arrow float-right"><i
                                    class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                            @can('banner-view')
                                <li><a href="{{ route('banner.index') }}"><i class="mdi mdi-image-filter"></i>Home Banners</a></li>
                            @endcan
                            @can('banner-view')
                                <li><a href="{{ route('advertisement.index') }}"><i class="mdi mdi-bullhorn"></i>Advertisements</a></li>
                            @endcan
                                <li><a href="{{ route('client.riviewes') }}"><i class="mdi mdi-message-text"></i>Client Feedback</a></li>
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

                @if (auth()->user()->can('user-view') || auth()->user()->can('customer-view'))
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="dripicons-user-group"></i><span>
                                Users </span> <span class="menu-arrow float-right"><i
                                    class="mdi mdi-chevron-right"></i></span></a>
                        <ul class="list-unstyled">
                            @can('user-view')
                                <li><a href="{{ url('user_view') }}"><i class="mdi mdi-account-star"></i>Staff Admin</a></li>
                            @endcan
                            @can('customer-view')
                                <li><a href="{{ route('customer.list') }}"><i class="mdi mdi-account-multiple"></i>Customers</a></li>
                            @endcan
                            @can('role-view')
                                <li><a href="{{ url('roleview') }}"><i class="mdi mdi-key-variant"></i>Roles & Permissions</a></li>
                            @endcan
                        </ul>
                    </li>
                @endif

                <li>
                    <a href="{{ route('settings.index') }}" class="waves-effect">
                        <i class="dripicons-gear"></i>
                        <span> General Settings </span>
                    </a>
                </li>

                @if (auth()->user()->can('Blog-view'))
                    <li>
                        <a href="{{ route('blog.index') }}" class="waves-effect">
                            <i class="dripicons-blog"></i>
                            <span> Blogs </span>
                        </a>
                    </li>
                @endif

                <li class="has_sub">
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
                        <li><a href="{{ route('terms.index') }}"><i class="mdi mdi-file-document-outline"></i>Terms & Conditions</a></li>
                        <li><a href="{{ route('privacy.index') }}"><i class="mdi mdi-lock-outline"></i>Privacy Policy</a></li>
                        <li><a href="{{ route('delivery.index') }}"><i class="mdi mdi-truck-delivery"></i>Delivery & Returns</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('contactlist.index') }}" class="waves-effect">
                        <i class="dripicons-mail"></i>
                        <span> Contact Submissions </span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('shippingchargesedit') }}" class="waves-effect">
                        <i class="dripicons-to-do"></i>
                        <span> Shipping Settings </span>
                    </a>
                </li>
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
