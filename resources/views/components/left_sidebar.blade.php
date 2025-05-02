<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{route('home')}}" >
            {{-- <img src="{{asset('vendors/images/logo/logo-dark.svg')}}" alt="" class="dark-logo"> --}}
            {{-- <img src="{{asset('vendors/images/logo/deskapp-logo-white.svg')}}" alt="" class="light-logo"> --}}
            <img src="{{asset('vendors/images/logo/logo-dark.svg')}}" alt="" class="dark-logo" width="20px" height="30px">

            <img src="{{asset('vendors/images/logo/logo-dark.svg')}}" alt="" class="light-logo" width="30px" height="30px">

            {{-- <span class="" style="color:rgb(61, 61, 231)">Nadi Yoon Htike
</span> --}}
            <span class="mx-1" style="color:rgb(229, 229, 236)">Nadi Yoon Htike
</span>
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li class="dropdown {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-house-1"></span><span class="mtext">Home</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                    </ul>
                </li>
                <li class="dropdown {{ request()->routeIs('admin.user') ? 'active' : '' }}">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-user-1"></span><span class="mtext">User</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('admin.user') }}" class="{{ request()->routeIs('admin.user') ? 'active' : '' }}">All User</a></li>
                    </ul>
                </li>


                 <li class="dropdown {{ request()->routeIs('main_categories.*') ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle">
                    <span class="micon dw dw-presentation"></span><span class="mtext">Main Category</span>
                </a>
                <ul class="submenu">
                    <li><a href="{{ route('main_categories.index') }}" class="{{ request()->routeIs('main_categories.index') ? 'active' : '' }}">All MainCategory</a></li>
                    <li><a href="{{ route('main_categories.create') }}" class="{{ request()->routeIs('main_categories.create') ? 'active' : '' }}">Create Main Category</a></li>
                    @if(request()->routeIs('main_categories.edit'))
                    <li><a href="{{ route('main_categories.edit', ['main_category' => request()->route('main_category')]) }}" class="{{ request()->routeIs('main_categories.edit') ? 'active' : '' }}">Edit Main Category</a></li>
                    @endif

                    @if(request()->routeIs('main_categories.show'))
                    <li><a href="{{ route('main_categories.show', ['main_category' => request()->route('main_category')]) }}" class="{{ request()->routeIs('main_categories.show') ? 'active' : '' }}">Show Main Category</a></li>
                    @endif

                </ul>
            </li>
            <li class="dropdown {{ request()->routeIs('brands.*') ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle">
                    {{-- ion-close-round --}}
                    <span class="micon dw dw-building"></span><span class="mtext">Brand</span>

                </a>
                <ul class="submenu">
                    <li><a href="{{ route('brands.index') }}" class="{{ request()->routeIs('brands.index') ? 'active' : '' }}">All Brand</a></li>
                    <li><a href="{{ route('brands.create') }}" class="{{ request()->routeIs('brands.create') ? 'active' : '' }}">Create Brand</a></li>

                    @if(request()->routeIs('brands.edit'))
                    <li><a href="{{ route('brands.edit', ['brand' => request()->route('brand')]) }}" class="{{ request()->routeIs('brands.edit') ? 'active' : '' }}">Edit Brand</a></li>
                    @endif

                    @if(request()->routeIs('brands.show'))
                    <li><a href="{{ route('brands.show', ['brand' => request()->route('brand')]) }}" class="{{ request()->routeIs('brands.show') ? 'active' : '' }}">Show Brand</a></li>
                    @endif


                </ul>
            </li>

            <li class="dropdown {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle">
                    <span class="micon dw dw-package"></span><span class="mtext">Category</span>
                </a>
                <ul class="submenu">
                    <li><a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.index') ? 'active' : '' }}">All Category</a></li>
                    <li><a href="{{ route('categories.create') }}" class="{{ request()->routeIs('categories.create') ? 'active' : '' }}">Create Category</a></li>
                    @if(request()->routeIs('categories.edit'))
                    <li><a href="{{ route('categories.edit', ['category' => request()->route('category')]) }}" class="{{ request()->routeIs('categories.edit') ? 'active' : '' }}">Edit Category</a></li>
                    @endif

                    @if(request()->routeIs('categories.show'))
                    <li><a href="{{ route('categories.show', ['category' => request()->route('category')]) }}" class="{{ request()->routeIs('categories.show') ? 'active' : '' }}">Show Category</a></li>
                    @endif

                </ul>
            </li>

            {{-- <li class="dropdown {{ request()->routeIs('subcategories.*') ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle">
                    <span class="micon dw dw-house-1"></span><span class="mtext">SubCategory</span>
                </a>
                <ul class="submenu">
                    <li><a href="{{ route('subcategories.index') }}" class="{{ request()->routeIs('subcategories.index') ? 'active' : '' }}">All SubCategory</a></li>
                    <li><a href="{{ route('subcategories.create') }}" class="{{ request()->routeIs('subcategories.create') ? 'active' : '' }}">Create SubCategory</a></li>
                    @if(request()->routeIs('subcategories.edit'))
                    <li><a href="{{ route('subcategories.edit', ['subcategory' => request()->route('subcategory')]) }}" class="{{ request()->routeIs('subcategories.edit') ? 'active' : '' }}">Edit SubCategory</a></li>
                    @endif

                    @if(request()->routeIs('subcategories.show'))
                    <li><a href="{{ route('subcategories.show', ['subcategory' => request()->route('subcategory')]) }}" class="{{ request()->routeIs('subcategories.show') ? 'active' : '' }}">Show SubCategory</a></li>
                    @endif
                </ul>
            </li> --}}


            <li class="dropdown {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-gift"></span><span class="mtext">Product</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.index') ? 'active' : '' }}">
                                All Product
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('products.create') }}" class="{{ request()->routeIs('products.create') ? 'active' : '' }}">
                                Add Product
                            </a>
                        </li>
                        @if(request()->routeIs('products.edit'))
                            <li>
                                <a href="{{ route('products.edit', ['product' => request()->route('product')]) }}" class="{{ request()->routeIs('products.edit') ? 'active' : '' }}">
                                    Edit Product
                                </a>
                            </li>
                        @endif
                        @if(request()->routeIs('products.show'))
                            <li>
                                <a href="{{ route('products.show', ['product' => request()->route('product')]) }}" class="{{ request()->routeIs('products.show') ? 'active' : '' }}">
                                    Show Product
                                </a>
                            </li>
                        @endif
                    </ul>
            </li>

                {{-- <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-house-1"></span><span class="mtext">Brand</span>



                    </a>
                    <ul class="submenu">
                        <li><a href="{{route('brands.index')}}">All Brand</a></li>
                <li><a href="{{route('brands.create')}}">Create Brand</a></li>
            </ul>
            </li>
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle">
                    <span class="micon dw dw-house-1"></span><span class="mtext">Category</span>
                </a>
                <ul class="submenu">
                    <li><a href="{{route('categories.index')}}">All Category</a></li>
                    <li><a href="{{route('categories.create')}}">Create Category</a></li>
                </ul>

            </li>
            <li class="dropdown">
                <a href="javascript:;" class="dropdown-toggle">
                    <span class="micon dw dw-house-1"></span><span class="mtext">SubCategory</span>
                </a>
                <ul class="submenu">
                    <li><a href="{{route('subcategories.index')}}">All SubCategory</a></li>
                    <li><a href="{{route('subcategories.create')}}">Create SubCategory</a></li>
                </ul>

            </li> --}}




            <li class="dropdown {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle">
                    <span class="micon dw dw-invoice-1"></span><span class="mtext">Orders</span>
                </a>

                <ul class="submenu">

                    <li><a href="{{ route('order.all') }}" class="{{ request()->routeIs('order.all') ? 'active' : '' }}">All Orders</a></li>
                    <li><a href="{{ route('order.pending') }}" class="{{ request()->routeIs('order.pending') ? 'active' : '' }}">Placed Orders</a></li>

                    <li><a href="{{ route('order.confirm') }}" class="{{ request()->routeIs('order.confirm') ? 'active' : '' }}">Shipped Orders</a></li>
                     <li><a href="{{ route('order.completed') }}" class="{{ request()->routeIs('order.completed') ? 'active' : '' }}">Delivered Orders</a></li>
                    <li><a href="{{ route('order.cancel') }}" class="{{ request()->routeIs('order.cancel') ? 'active' : '' }}">Cancel Orders</a></li>

                    {{-- <li><a href="{{ route('payment_type.create') }}" class="{{ request()->routeIs('payment_type.create') ? 'active' : '' }}">Add Bank or Pay</a></li>


                    @if(request()->routeIs('payment_type.edit'))
                    <li><a href="{{ route('payment_type.edit', ['payment_type' => request()->route('payment_type')]) }}" class="{{ request()->routeIs('payment_type.edit') ? 'active' : '' }}">Edit Bank or Pay</a></li>
                    @endif

                    @if(request()->routeIs('payment_type.show'))
                    <li><a href="{{ route('payment_type.show', ['payment_type' => request()->route('payment_type')]) }}" class="{{ request()->routeIs('payment_type.show') ? 'active' : '' }}">Show Bank or Pay</a></li>
                    @endif --}}



                </ul>
            </li>

            <li class="dropdown {{ request()->routeIs('payment_type.*') ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle">
                    <span class="micon dw dw-money-2"></span><span class="mtext">Bank</span>
                </a>

                <ul class="submenu">

                    <li><a href="{{ route('payment_type.index') }}" class="{{ request()->routeIs('payment_type.index') ? 'active' : '' }}">All Payment Type</a></li>

                    <li><a href="{{ route('payment_type.create') }}" class="{{ request()->routeIs('payment_type.create') ? 'active' : '' }}">Add Bank or Pay</a></li>


                    @if(request()->routeIs('payment_type.edit'))
                    <li><a href="{{ route('payment_type.edit', ['payment_type' => request()->route('payment_type')]) }}" class="{{ request()->routeIs('payment_type.edit') ? 'active' : '' }}">Edit Bank or Pay</a></li>
                    @endif

                    @if(request()->routeIs('payment_type.show'))
                    <li><a href="{{ route('payment_type.show', ['payment_type' => request()->route('payment_type')]) }}" class="{{ request()->routeIs('payment_type.show') ? 'active' : '' }}">Show Bank or Pay</a></li>
                    @endif



                </ul>
            </li>
             <li class="dropdown {{ request()->routeIs('account.*') ? 'active' : '' }}">
                <a href="javascript:;" class="dropdown-toggle">
                    <span class="micon dw dw-money-2"></span><span class="mtext">Receving Account </span>
                </a>

                <ul class="submenu">

                    <li><a href="{{ route('account.index') }}" class="{{ request()->routeIs('account.index') ? 'active' : '' }}">All Accounts</a></li>

                    <li><a href="{{ route('account.create') }}" class="{{ request()->routeIs('account.create') ? 'active' : '' }}">Add Account</a></li>


                    @if(request()->routeIs('account.edit'))
                    <li><a href="{{ route('account.edit', ['account' => request()->route('account')]) }}" class="{{ request()->routeIs('account.edit') ? 'active' : '' }}">Edit Account </a></li>
                    @endif

                    @if(request()->routeIs('account.show'))
                    <li><a href="{{ route('account.show', ['account' => request()->route('account')]) }}" class="{{ request()->routeIs('account.show') ? 'active' : '' }}">Show Account </a></li>
                    @endif



                </ul>
            </li>












            </ul>
        </div>
    </div>
</div>
