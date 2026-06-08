/**
 * Dernek Framework Frontend JS Core
 */
document.addEventListener('DOMContentLoaded', () => {
    // Utility functions
    function escapeHtml(str) {
        if (!str) return '';
        return str.replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatCurrency(num) {
        return new Intl.NumberFormat('tr-TR', { maximumFractionDigits: 0 }).format(num);
    }

    // Dynamic cart UI rendering
    function renderCartItems(items) {
        const container = document.getElementById('cart-drawer-items');
        const footer = document.getElementById('cart-drawer-footer');
        const totalEl = document.getElementById('cart-drawer-total');
        const badge = document.getElementById('cart-badge');

        if (!container) return;

        const count = items.length;
        if (badge) {
            badge.innerText = count;
            if (count > 0) {
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        if (count === 0) {
            container.innerHTML = `
                <div class="cart-empty-state h-full flex flex-col items-center justify-center text-center p-6 space-y-4">
                    <div class="w-16 h-16 rounded-pill bg-surface-alt/60 flex items-center justify-center text-text-muted">
                        <i class="ri-shopping-basket-2-line text-3xl"></i>
                    </div>
                    <div>
                        <h4 class="font-heading font-bold text-secondary text-base">Sepetiniz Boş</h4>
                        <p class="font-sans text-xs text-text-muted mt-1">Henüz sepetinize bir bağış eklemediniz.</p>
                    </div>
                    <a href="/bagislar/" class="inline-flex bg-primary hover:bg-primary-hover text-white text-xs font-bold px-5 py-2.5 rounded-medium transition-colors">
                        Bağışları İncele
                    </a>
                </div>
            `;
            if (footer) footer.classList.add('hidden');
        } else {
            let html = '';
            let total = 0;

            items.forEach(item => {
                const lineTotal = item.unitAmount * item.quantity;
                total += lineTotal;
                html += `
                    <div class="cart-item flex items-center justify-between gap-4 p-3 bg-surface-alt/30 border border-border/40 rounded-medium transition-all" data-line-key="${item.lineKey}">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-sans font-bold text-xs text-secondary truncate mb-1">${escapeHtml(item.title)}</h4>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="qty-selector scale-90 origin-left" data-quantity-selector>
                                    <button type="button" class="qty-selector-btn cart-qty-btn" data-line-key="${item.lineKey}" data-action="decrease">
                                        <i class="ri-subtract-line text-xs"></i>
                                    </button>
                                    <span class="qty-selector-text" id="qty-text-${item.lineKey}">
                                        ${item.quantity}
                                    </span>
                                    <button type="button" class="qty-selector-btn cart-qty-btn" data-line-key="${item.lineKey}" data-action="increase">
                                        <i class="ri-add-line text-xs"></i>
                                    </button>
                                </div>
                                <span class="text-[10px] text-text-muted select-none">
                                    &times; ${formatCurrency(item.unitAmount)} ₺
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="font-sans font-black text-xs text-secondary whitespace-nowrap">
                                ${formatCurrency(lineTotal)} ₺
                            </span>
                            <button class="cart-item-remove text-text-muted hover:text-danger transition-colors cursor-pointer" data-line-key="${item.lineKey}" aria-label="Sil">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </div>
                    </div>
                `;
            });

            container.innerHTML = html;
            if (totalEl) totalEl.innerText = `${formatCurrency(total)} ₺`;
            if (footer) footer.classList.remove('hidden');

            // Bind dynamic delete events
            container.querySelectorAll('.cart-item-remove').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const lineKey = this.getAttribute('data-line-key');
                    removeCartItem(lineKey);
                });
            });

            // Bind dynamic quantity change events
            container.querySelectorAll('.cart-qty-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const lineKey = this.getAttribute('data-line-key');
                    const action = this.getAttribute('data-action');
                    updateCartQty(lineKey, action);
                });
            });
        }
    }

    // API Calls
    async function removeCartItem(lineKey) {
        try {
            const response = await fetch(`/wp-json/hiyad/v1/cart/items/${lineKey}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            if (response.ok) {
                const data = await response.json();
                renderCartItems(data.items || []);
                // If on checkout page, reload to sync checkout state
                if (window.location.pathname.includes('/odeme')) {
                    window.location.reload();
                }
            } else {
                console.error('Failed to remove cart item');
            }
        } catch (err) {
            console.error('Error removing cart item:', err);
        }
    }

    async function updateCartQty(lineKey, action) {
        const qtyTextEl = document.getElementById(`qty-text-${lineKey}`);
        if (!qtyTextEl) return;

        let currentQty = parseInt(qtyTextEl.textContent.trim()) || 1;
        let newQty = currentQty;

        if (action === 'increase') {
            newQty = currentQty + 1;
        } else if (action === 'decrease') {
            newQty = currentQty - 1;
        }

        if (newQty <= 0) {
            removeCartItem(lineKey);
            return;
        }

        try {
            const formData = new FormData();
            formData.append('action', 'peta_update_quantity');
            formData.append('line_key', lineKey);
            formData.append('quantity', newQty);

            const response = await fetch('/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: formData
            });

            if (response.ok) {
                const result = await response.json();
                if (result.success) {
                    renderCartItems(result.data.items || []);
                    // If on checkout page, reload to sync checkout state
                    if (window.location.pathname.includes('/odeme')) {
                        window.location.reload();
                    }
                } else {
                    alert(result.data?.message || 'Miktar güncellenirken bir hata oluştu.');
                }
            } else {
                console.error('Failed to update cart quantity');
            }
        } catch (err) {
            console.error('Error updating quantity:', err);
        }
    }

    async function clearCart() {
        try {
            const response = await fetch(`/wp-json/hiyad/v1/cart`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            if (response.ok) {
                const data = await response.json();
                renderCartItems(data.items || []);
                if (window.location.pathname.includes('/odeme')) {
                    window.location.reload();
                }
            } else {
                console.error('Failed to clear cart');
            }
        } catch (err) {
            console.error('Error clearing cart:', err);
        }
    }

    // Cart Drawer Overlay Actions
    const cartDrawerBackdrop = document.getElementById('cart-drawer-backdrop');
    const cartDrawer = document.getElementById('cart-drawer');
    const cartDrawerTrigger = document.getElementById('cart-drawer-trigger');
    const cartDrawerClose = document.getElementById('cart-drawer-close');
    const clearCartBtn = document.getElementById('cart-drawer-clear');

    function openCartDrawer() {
        if (!cartDrawerBackdrop || !cartDrawer) return;
        cartDrawerBackdrop.classList.remove('opacity-0', 'pointer-events-none');
        cartDrawerBackdrop.classList.add('opacity-100', 'pointer-events-auto');
        cartDrawer.classList.remove('translate-x-full');
        cartDrawer.classList.add('translate-x-0');
    }

    function closeCartDrawer() {
        if (!cartDrawerBackdrop || !cartDrawer) return;
        cartDrawerBackdrop.classList.add('opacity-0', 'pointer-events-none');
        cartDrawerBackdrop.classList.remove('opacity-100', 'pointer-events-auto');
        cartDrawer.classList.add('translate-x-full');
        cartDrawer.classList.remove('translate-x-0');
    }

    if (cartDrawerTrigger) {
        cartDrawerTrigger.addEventListener('click', (e) => {
            e.preventDefault();
            openCartDrawer();
        });
    }

    if (cartDrawerClose) {
        cartDrawerClose.addEventListener('click', closeCartDrawer);
    }

    if (cartDrawerBackdrop) {
        cartDrawerBackdrop.addEventListener('click', (e) => {
            if (e.target === cartDrawerBackdrop) {
                closeCartDrawer();
            }
        });
    }

    // Bind initial cart item remove buttons on load
    document.querySelectorAll('.cart-item-remove').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const lineKey = this.getAttribute('data-line-key');
            removeCartItem(lineKey);
        });
    });

    // Bind initial cart item quantity change buttons on load
    document.querySelectorAll('.cart-qty-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const lineKey = this.getAttribute('data-line-key');
            const action = this.getAttribute('data-action');
            updateCartQty(lineKey, action);
        });
    });

    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', function (e) {
            e.preventDefault();
            clearCart();
        });
    }

    // Intercept all donation card submissions
    const donationForms = document.querySelectorAll('.donation-form');
    donationForms.forEach(form => {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const priceInput = form.querySelector('.price-input');
            if (priceInput && !priceInput.readOnly && priceInput.type === 'number') {
                const amt = parseInt(priceInput.value || 0);
                if (amt < 20) {
                    alert('Minimum bağış tutarı 20 TL\'dir.');
                    return;
                }
            }

            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.setAttribute('data-original-html', submitBtn.innerHTML);
                submitBtn.innerHTML = `<i class="ri-loader-4-line animate-spin mr-2"></i> Ekleniyor...`;
            }

            try {
                const formData = new FormData(form);
                const response = await fetch(form.getAttribute('action'), {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    const cartResponse = await fetch('/wp-json/hiyad/v1/cart');
                    if (cartResponse.ok) {
                        const cartData = await cartResponse.json();
                        renderCartItems(cartData.items || []);
                        openCartDrawer();

                        const qtyInput = form.querySelector('input[name="quantity"]');
                        if (qtyInput) qtyInput.value = 1;
                    }
                } else {
                    alert('Bağış sepete eklenirken bir hata oluştu.');
                }
            } catch (err) {
                console.error('Add to cart error:', err);
                alert('Bağlantı hatası oluştu.');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    const orig = submitBtn.getAttribute('data-original-html');
                    if (orig) submitBtn.innerHTML = orig;
                }
            }
        });
    });

    // Login Dropdown
    const userMenuTrigger = document.getElementById('user-menu-trigger');
    const userDropdown = document.getElementById('user-dropdown');

    if (userMenuTrigger && userDropdown) {
        userMenuTrigger.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const isHidden = userDropdown.classList.contains('hidden');
            if (isHidden) {
                userDropdown.classList.remove('hidden');
                setTimeout(() => {
                    userDropdown.classList.remove('opacity-0', 'scale-95');
                    userDropdown.classList.add('opacity-100', 'scale-100');
                }, 10);
            } else {
                userDropdown.classList.remove('opacity-100', 'scale-100');
                userDropdown.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    userDropdown.classList.add('hidden');
                }, 200);
            }
        });

        document.addEventListener('click', (e) => {
            if (!userDropdown.classList.contains('hidden') && !userDropdown.contains(e.target) && e.target !== userMenuTrigger) {
                userDropdown.classList.remove('opacity-100', 'scale-100');
                userDropdown.classList.add('opacity-0', 'scale-95');
                setTimeout(() => {
                    userDropdown.classList.add('hidden');
                }, 200);
            }
        });
    }

    // Login Modal Overlay Actions
    const loginModalBackdrop = document.getElementById('login-modal-backdrop');
    const loginModal = document.getElementById('login-modal');
    const loginModalTrigger = document.getElementById('login-modal-trigger');
    const loginModalClose = document.getElementById('login-modal-close');

    const sendForm = document.getElementById('otp-send-form');
    const verifyForm = document.getElementById('otp-verify-form');
    const alertBox = document.getElementById('login-alert');
    const phoneInput = document.getElementById('login-phone');
    const backBtn = document.getElementById('otp-back-btn');
    const logoutBtn = document.getElementById('header-logout-btn');

    let activePhone = '';
    let timerInterval = null;

    // Initialize intl-tel-input for login phone
    let loginIti = null;
    if (phoneInput && typeof window.intlTelInput !== 'undefined') {
        loginIti = window.intlTelInput(phoneInput, {
            initialCountry: "tr",
            preferredCountries: ["tr", "us", "de", "gb"],
            nationalMode: false,
            autoPlaceholder: "aggressive",
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/utils.js"
        });

        // Dynamic mask based on country placeholder format & automatically add country code
        phoneInput.addEventListener('input', function () {
            let cursor = phoneInput.selectionStart;
            let originalLen = phoneInput.value.length;
            let val = phoneInput.value;

            if (!val.startsWith('+')) {
                let digits = val.replace(/\D/g, '');
                val = digits ? '+' + digits : '';
            }

            let digits = val.replace(/\D/g, '');
            if (typeof intlTelInputUtils !== 'undefined' && digits.length > 0) {
                let formatted = intlTelInputUtils.formatNumber('+' + digits, loginIti.getSelectedCountryData().iso2, intlTelInputUtils.numberFormat.INTERNATIONAL);
                if (formatted) {
                    phoneInput.value = formatted;
                    let newLen = formatted.length;
                    phoneInput.setSelectionRange(cursor + (newLen - originalLen), cursor + (newLen - originalLen));
                }
            }
        });

        phoneInput.addEventListener('focus', function () {
            if (phoneInput.value.trim() === '') {
                const dial = '+' + loginIti.getSelectedCountryData().dialCode;
                phoneInput.value = dial + ' ';
            }
        });

        phoneInput.addEventListener('blur', function () {
            const dial = '+' + loginIti.getSelectedCountryData().dialCode;
            if (phoneInput.value.trim() === dial || phoneInput.value.trim() === '+' || phoneInput.value.trim() === '') {
                phoneInput.value = '';
            }
        });

        phoneInput.addEventListener('countrychange', function () {
            const dial = '+' + loginIti.getSelectedCountryData().dialCode;
            phoneInput.value = dial + ' ';
        });
    }

    function openLoginModal() {
        if (!loginModalBackdrop || !loginModal) return;
        loginModalBackdrop.classList.remove('opacity-0', 'pointer-events-none');
        loginModalBackdrop.classList.add('opacity-100', 'pointer-events-auto');
        loginModal.classList.remove('scale-95', 'opacity-0');
        loginModal.classList.add('scale-100', 'opacity-100');
    }

    function closeLoginModal() {
        if (!loginModalBackdrop || !loginModal) return;
        loginModalBackdrop.classList.add('opacity-0', 'pointer-events-none');
        loginModalBackdrop.classList.remove('opacity-100', 'pointer-events-auto');
        loginModal.classList.add('scale-95', 'opacity-0');
        loginModal.classList.remove('scale-100', 'opacity-100');
        if (sendForm) sendForm.classList.remove('hidden');
        if (verifyForm) verifyForm.classList.add('hidden');
        if (alertBox) alertBox.classList.add('hidden');
        clearInterval(timerInterval);
    }

    if (loginModalTrigger) {
        loginModalTrigger.addEventListener('click', (e) => {
            e.preventDefault();
            openLoginModal();
        });
    }

    if (loginModalClose) {
        loginModalClose.addEventListener('click', closeLoginModal);
    }

    if (loginModalBackdrop) {
        loginModalBackdrop.addEventListener('click', (e) => {
            if (e.target === loginModalBackdrop) {
                closeLoginModal();
            }
        });
    }

    function showAlert(message, type) {
        if (!alertBox) return;
        alertBox.innerText = message;
        alertBox.classList.remove('hidden', 'bg-success/10', 'border-success/20', 'text-success', 'bg-danger/10', 'border-danger/20', 'text-danger');
        if (type === 'success') {
            alertBox.classList.add('bg-success/10', 'border-success/20', 'text-success');
        } else {
            alertBox.classList.add('bg-danger/10', 'border-danger/20', 'text-danger');
        }
        alertBox.classList.remove('hidden');
    }

    function setLoading(formEl, isLoading) {
        const btn = formEl.querySelector('button[type="submit"]');
        if (!btn) return;
        if (isLoading) {
            btn.disabled = true;
            btn.setAttribute('data-original-html', btn.innerHTML);
            btn.innerHTML = `<i class="ri-loader-4-line animate-spin text-lg mr-2"></i> Lütfen bekleyin...`;
        } else {
            btn.disabled = false;
            const original = btn.getAttribute('data-original-html');
            if (original) btn.innerHTML = original;
        }
    }

    function startOtpTimer() {
        const timerEl = document.getElementById('otp-timer');
        if (!timerEl) return;
        let seconds = 120;
        timerEl.innerText = seconds;

        clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            seconds--;
            timerEl.innerText = seconds;
            if (seconds <= 0) {
                clearInterval(timerInterval);
                showAlert('Süre doldu, lütfen kodu tekrar gönderin.', 'error');
                if (verifyForm) verifyForm.classList.add('hidden');
                if (sendForm) sendForm.classList.remove('hidden');
            }
        }, 1000);
    }

    if (sendForm) {
        sendForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            if (alertBox) alertBox.classList.add('hidden');

            if (loginIti) {
                if (!loginIti.isValidNumber()) {
                    showAlert('Lütfen geçerli bir telefon numarası girin.', 'error');
                    return;
                }
                activePhone = loginIti.getNumber();
            } else {
                const rawPhone = phoneInput.value.replace(/\s+/g, '');
                if (!/^[0-9]{10}$/.test(rawPhone)) {
                    showAlert('Lütfen geçerli bir telefon numarası girin (5XX XXX XXxx).', 'error');
                    return;
                }
                activePhone = '+90' + rawPhone;
            }
            setLoading(sendForm, true);

            try {
                const response = await fetch('/_esas/gateway.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        operationName: 'endUserSendOtp',
                        query: 'query endUserSendOtp($phone: String!) { endUserSendOtp(phone: $phone) }',
                        variables: { phone: activePhone }
                    })
                });

                const result = await response.json();
                if (response.ok && result.data && result.data.endUserSendOtp) {
                    sendForm.classList.add('hidden');
                    if (verifyForm) verifyForm.classList.remove('hidden');
                    showAlert('Doğrulama kodu telefonunuza gönderildi.', 'success');
                    startOtpTimer();
                } else {
                    showAlert(result.message || 'Kod gönderilirken bir hata oluştu.', 'error');
                }
            } catch (err) {
                showAlert('Bağlantı hatası oluştu.', 'error');
            } finally {
                setLoading(sendForm, false);
            }
        });
    }

    if (verifyForm) {
        verifyForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            if (alertBox) alertBox.classList.add('hidden');

            const otpInput = document.getElementById('login-otp');
            const otp = otpInput.value.trim();
            if (otp.length !== 6) {
                showAlert('Lütfen 6 haneli doğrulama kodunu girin.', 'error');
                return;
            }

            setLoading(verifyForm, true);

            try {
                const response = await fetch('/_esas/gateway.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        operationName: 'endUserLogin',
                        query: 'query endUserLogin($phone: String!, $otp: String!) { endUserLogin(phone: $phone, otp: $otp) }',
                        variables: { phone: activePhone, otp }
                    })
                });

                const result = await response.json();
                if (response.ok && result.data && result.data.endUserLogin) {
                    clearInterval(timerInterval);
                    showAlert('Giriş başarılı! Yönlendiriliyorsunuz...', 'success');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    showAlert(result.message || 'Hatalı kod girdiniz.', 'error');
                }
            } catch (err) {
                showAlert('Bağlantı hatası oluştu.', 'error');
            } finally {
                setLoading(verifyForm, false);
            }
        });
    }

    if (backBtn) {
        backBtn.addEventListener('click', () => {
            clearInterval(timerInterval);
            if (verifyForm) verifyForm.classList.add('hidden');
            if (sendForm) sendForm.classList.remove('hidden');
            if (alertBox) alertBox.classList.add('hidden');
        });
    }

    if (logoutBtn) {
        logoutBtn.addEventListener('click', async function (e) {
            e.preventDefault();
            try {
                const response = await fetch('/wp-admin/admin-ajax.php?action=peta_logout', {
                    method: 'POST'
                });
                if (response.ok) {
                    window.location.reload();
                } else {
                    alert('Çıkış yapılırken hata oluştu.');
                }
            } catch (err) {
                console.error('Logout error:', err);
            }
        });
    }

    // Initialize CRM Donation Cards
    function initDonationCards() {
        const forms = document.querySelectorAll('.donation-form');
        forms.forEach(form => {
            const select = form.querySelector('.product-variant-select');
            const priceInput = form.querySelector('.price-input');
            const unitAmountInput = form.querySelector('.unit-amount-hidden');
            const qtyInput = form.querySelector('input[name="quantity"]');

            if (!priceInput || !unitAmountInput || !qtyInput) return;

            function updateDisplayPrice() {
                const unitPrice = parseFloat(unitAmountInput.value || 0);
                const qty = parseInt(qtyInput.value || 1);
                const total = unitPrice * qty;

                if (priceInput.readOnly) {
                    priceInput.value = new Intl.NumberFormat('tr-TR').format(total);
                } else {
                    priceInput.value = total;
                }
            }

            if (select) {
                select.addEventListener('change', function () {
                    const selectedOpt = select.options[select.selectedIndex];
                    const price = parseFloat(selectedOpt.getAttribute('data-price') || 0);
                    if (price <= 0) {
                        unitAmountInput.value = "250";
                        priceInput.readOnly = false;
                        priceInput.type = "number";
                        priceInput.required = true;
                    } else {
                        unitAmountInput.value = price;
                        priceInput.readOnly = true;
                        priceInput.type = "text";
                        priceInput.required = false;
                    }
                    updateDisplayPrice();
                });
            }

            qtyInput.addEventListener('change', updateDisplayPrice);
            qtyInput.addEventListener('input', updateDisplayPrice);

            if (!priceInput.readOnly) {
                priceInput.addEventListener('input', function () {
                    const total = parseFloat(priceInput.value || 0);
                    const qty = parseInt(qtyInput.value || 1);
                    const unitPrice = total / qty;
                    unitAmountInput.value = unitPrice;
                });
            }

            // Initial calculation
            updateDisplayPrice();
        });
    }

    // Global delegated listener for static quantity selectors
    document.addEventListener('click', (e) => {
        const btn = e.target.closest('[data-quantity-selector] .qty-selector-btn');
        if (!btn) return;

        // If it's an AJAX selector button (has data-line-key), let the specific AJAX handler handle it
        if (btn.hasAttribute('data-line-key')) {
            return;
        }

        e.preventDefault();
        const container = btn.closest('[data-quantity-selector]');
        const input = container.querySelector('.qty-selector-input');
        if (!input) return;

        const action = btn.getAttribute('data-action');
        const val = parseInt(input.value) || 1;
        const min = parseInt(input.getAttribute('min')) || 1;
        const step = parseInt(input.getAttribute('step')) || 1;

        if (action === 'decrease') {
            if (val > min) {
                input.value = val - step;
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));
            }
        } else if (action === 'increase') {
            input.value = val + step;
            input.dispatchEvent(new Event('input', { bubbles: true }));
            input.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });

    // Run CRM Donation Card Initialization
    initDonationCards();
});
