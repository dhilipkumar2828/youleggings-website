document.addEventListener('DOMContentLoaded', () => {
    // Initialize Lucide Icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Header scroll effect
    const header = document.querySelector('.header');
    const updateHeader = () => {
        if (window.scrollY > 50) {
            header?.classList.add('scrolled');
        } else {
            header?.classList.remove('scrolled');
        }
    };
    window.addEventListener('scroll', updateHeader);
    updateHeader();

    // Search Toggle
    const searchToggleBtn = document.getElementById('searchToggleBtn');
    const searchCloseBtn = document.getElementById('searchCloseBtn');
    const headerSearchBar = document.getElementById('headerSearchBar');
    const headerSearchInput = headerSearchBar ? headerSearchBar.querySelector('input') : null;

    if (searchToggleBtn && headerSearchBar) {
        searchToggleBtn.addEventListener('click', () => {
            headerSearchBar.classList.toggle('open');
            if (headerSearchBar.classList.contains('open') && headerSearchInput) {
                headerSearchInput.focus();
            }
        });
    }

    if (searchCloseBtn && headerSearchBar) {
        searchCloseBtn.addEventListener('click', () => {
            headerSearchBar.classList.remove('open');
        });
    }

    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navLinks = document.querySelector('.nav-links');

    if (mobileMenuBtn && navLinks) {
        mobileMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isActive = navLinks.classList.toggle('active');
            document.body.classList.toggle('menu-open', isActive);
            
            // Fix: Target both i and svg as Lucide replaces the element
            const menuIcon = mobileMenuBtn.querySelector('i, svg');
            if (isActive) {
                menuIcon?.setAttribute('data-lucide', 'x');
            } else {
                menuIcon?.setAttribute('data-lucide', 'menu');
            }
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });

        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (navLinks.classList.contains('active') && !navLinks.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                navLinks.classList.remove('active');
                document.body.classList.remove('menu-open');
                const menuIcon = mobileMenuBtn.querySelector('i');
                menuIcon?.setAttribute('data-lucide', 'menu');
                if (typeof lucide !== 'undefined') lucide.createIcons();
            }
        });
    }


    // Cart Navigation Update
    const CART_STORAGE_KEY = 'you_cart_items';
    
    // Add to Cart Logic
    const addToCartBtn = document.getElementById('productAddToCartBtn');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', () => {
            const productTitle = document.querySelector('.product-detail-title')?.innerText;
            const priceContainer = document.getElementById('productDetailPrice');
            const discountedPriceEl = priceContainer ? priceContainer.querySelector('.discounted-price') : null;
            let priceText = '0';
            if (discountedPriceEl) {
                // Get the explicit discounted price text
                priceText = discountedPriceEl.innerText.trim();
            } else if (priceContainer) {
                // If it's a mix like "500 495" or "500\n495", grab the last part
                const pieces = priceContainer.innerText.trim().split(/\s+/);
                priceText = pieces[pieces.length - 1];
            }
            
            const productPrice = priceText.replace(/[^\d\.]/g, '');
            const productImg = document.getElementById('productDetailImage')?.src;
            const activeSize = document.querySelector('.product-size-list button.is-active')?.innerText;
            
            if (!productTitle) return;
            
            let cart = JSON.parse(localStorage.getItem(CART_STORAGE_KEY) || '[]');
            const existing = cart.find(item => item.name === productTitle && item.variant === activeSize);
            
            if (existing) {
                existing.qty = (existing.qty || 1) + 1;
            } else {
                cart.push({
                    name: productTitle,
                    price: Number(productPrice),
                    image: productImg,
                    variant: activeSize || 'One Size',
                    qty: 1
                });
            }
            
            localStorage.setItem(CART_STORAGE_KEY, JSON.stringify(cart));
            updateCartBadge();
            window.showToast('Product added to cart!', 'success');
        });
    }

    function updateCartBadge() {
        const badge = document.getElementById('cartCountBadge');
        if (!badge) return;
        try {
            const cartItems = JSON.parse(localStorage.getItem(CART_STORAGE_KEY) || '[]');
            const totalItems = cartItems.reduce((sum, item) => sum + (Number(item.qty) || 0), 0);
            badge.textContent = String(totalItems);
            badge.classList.toggle('has-items', totalItems > 0);
        } catch (e) {
            console.error('Cart badge error', e);
        }
    }
    updateCartBadge();
    window.addEventListener('storage', updateCartBadge);

    // Toast Notification System
    window.showToast = function(message, type = 'success') {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        const icon = type === 'success' ? 'check' : (type === 'error' ? 'x' : 'info');

        toast.innerHTML = `
            <div class="toast-icon"><i data-lucide="${icon}"></i></div>
            <div class="toast-message">${message}</div>
        `;

        container.appendChild(toast);
        if (typeof lucide !== 'undefined') lucide.createIcons();

        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 500);
        }, 4000);
    };
});
